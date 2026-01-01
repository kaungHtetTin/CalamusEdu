<?php

namespace App\Services;

use Vimeo\Vimeo;
use Illuminate\Support\Facades\Log;

class VimeoService
{
    protected $vimeo;
    protected $clientId;
    protected $clientSecret;
    protected $accessToken;

    public function __construct()
    {
        $this->clientId = config('services.vimeo.client_id');
        $this->clientSecret = config('services.vimeo.client_secret');
        $this->accessToken = config('services.vimeo.access_token');

        if (!$this->clientId || !$this->clientSecret || !$this->accessToken) {
            throw new \Exception('Vimeo credentials not configured. Please add VIMEO_CLIENT_ID, VIMEO_CLIENT_SECRET, and VIMEO_ACCESS_TOKEN to your .env file.');
        }

        $this->vimeo = new Vimeo($this->clientId, $this->clientSecret, $this->accessToken);
    }

    /**
     * Upload video to Vimeo and organize in folder structure
     * 
     * @param \Illuminate\Http\UploadedFile $file The video file to upload
     * @param string $title Video title
     * @param string $language Language name (e.g., 'english', 'russian')
     * @param string|null $folderName Folder name (e.g., course title, lesson name)
     * @param string|null $subFolderName Optional subfolder name (e.g., 'Preview')
     * @return string Player URL in format: https://player.vimeo.com/video/{id}?h={hash}&title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=58479
     * @throws \Exception
     */
    public function uploadVideo($file, $title, $language, $folderName = null, $subFolderName = 'Preview')
    {
        try {
            // Step 1: Create folder structure if folder name is provided
            $targetFolderUri = null;
            
            if ($folderName) {
                $targetFolderUri = $this->createFolderStructure($language, $folderName, $subFolderName);
            }

            // Step 2: Upload video
            $filePath = $file->getRealPath();
            
            $uploadParams = [
                'name' => $title,
                'description' => 'Video uploaded via API',
            ];
            
            // Add folder_uri to upload parameters if we have a target folder
            if ($targetFolderUri) {
                $uploadParams['folder_uri'] = $targetFolderUri;
                Log::info('Uploading video to folder', ['folder_uri' => $targetFolderUri]);
            }

            // Upload the video
            $videoUri = $this->vimeo->upload($filePath, $uploadParams);

            if (!$videoUri) {
                throw new \Exception('Failed to upload video to Vimeo - no URI returned');
            }
            
            Log::info('Video uploaded successfully', ['video_uri' => $videoUri]);
            
            // Step 3: Move video to folder if folder_uri didn't work during upload
            if ($targetFolderUri) {
                $this->moveVideoToFolder($videoUri, $targetFolderUri);
            }

            // Step 4: Get embed code and construct player URL
            $playerUrl = $this->getPlayerUrl($videoUri);

            return $playerUrl;

        } catch (\Exception $e) {
            Log::error('Vimeo upload error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Vimeo upload error: ' . $e->getMessage());
        }
    }

    /**
     * Create folder structure: Language -> Folder -> SubFolder
     * 
     * @param string $language Language name
     * @param string $folderName Main folder name
     * @param string|null $subFolderName Optional subfolder name
     * @return string|null URI of the target folder (subfolder if provided, otherwise main folder)
     */
    protected function createFolderStructure($language, $folderName, $subFolderName = null)
    {
        try {
            // Step 1: Create or get language folder (root level)
            $languageFolderUri = $this->createFolder(ucfirst($language), null);
            
            if (!$languageFolderUri) {
                Log::warning('Failed to create language folder');
                return null;
            }
            
            Log::info('Language folder created', ['uri' => $languageFolderUri]);
            
            // Step 2: Create or get main folder inside language folder
            $sanitizedFolderName = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $folderName);
            $sanitizedFolderName = substr($sanitizedFolderName, 0, 100);
            
            $mainFolderUri = $this->createFolder($sanitizedFolderName, $languageFolderUri);
            
            if (!$mainFolderUri) {
                Log::warning('Failed to create main folder');
                return null;
            }
            
            Log::info('Main folder created', [
                'uri' => $mainFolderUri,
                'parent' => $languageFolderUri
            ]);
            
            // Step 3: Create subfolder if specified
            if ($subFolderName) {
                $subFolderUri = $this->createFolder($subFolderName, $mainFolderUri);
                
                if ($subFolderUri) {
                    Log::info('Subfolder created', [
                        'uri' => $subFolderUri,
                        'parent' => $mainFolderUri
                    ]);
                    return $subFolderUri;
                }
            }
            
            return $mainFolderUri;

        } catch (\Exception $e) {
            Log::error('Folder structure creation failed', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create or get a folder in Vimeo
     */
    protected function createFolder($folderName, $parentFolderUri = null)
    {
        try {
            // Check if folder already exists
            $existingFolderUri = $this->findFolder($folderName, $parentFolderUri);
            if ($existingFolderUri) {
                Log::info('Folder already exists', [
                    'folder_name' => $folderName,
                    'folder_uri' => $existingFolderUri
                ]);
                return $existingFolderUri;
            }

            // Create the folder
            $createData = ['name' => $folderName];
            
            if ($parentFolderUri) {
                $createData['parent_folder_uri'] = $parentFolderUri;
            }

            $createResponse = $this->vimeo->request('/me/projects', $createData, 'POST');
            
            $statusCode = $createResponse['status'] ?? 0;
            
            if ($statusCode >= 200 && $statusCode < 300 && isset($createResponse['body']['uri'])) {
                $folderUri = $createResponse['body']['uri'];
                
                // Verify parent if nested
                if ($parentFolderUri) {
                    $verifyResponse = $this->vimeo->request($folderUri . '?fields=parent_folder');
                    $actualParent = $verifyResponse['body']['parent_folder']['uri'] ?? null;
                    
                    if ($actualParent !== $parentFolderUri) {
                        Log::warning('Folder created but parent mismatch, attempting to move', [
                            'expected' => $parentFolderUri,
                            'actual' => $actualParent
                        ]);
                        
                        // Try to move folder to correct parent
                        $this->moveFolderToParent($folderUri, $parentFolderUri);
                    }
                }
                
                Log::info('Folder created successfully', [
                    'folder_name' => $folderName,
                    'folder_uri' => $folderUri
                ]);
                return $folderUri;
            } else {
                Log::error('Folder creation failed', [
                    'folder_name' => $folderName,
                    'status_code' => $statusCode,
                    'response' => $createResponse
                ]);
                return null;
            }

        } catch (\Exception $e) {
            Log::error('Exception creating folder', [
                'folder_name' => $folderName,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Find an existing folder
     */
    protected function findFolder($folderName, $parentFolderUri = null)
    {
        try {
            if ($parentFolderUri) {
                $response = $this->vimeo->request($parentFolderUri . '/items?per_page=100');
            } else {
                $response = $this->vimeo->request('/me/projects?per_page=100');
            }

            if (isset($response['body']['data'])) {
                $items = $response['body']['data'];
                
                foreach ($items as $item) {
                    if (isset($item['type']) && $item['type'] === 'project' && 
                        isset($item['name']) && $item['name'] === $folderName) {
                        return $item['uri'];
                    }
                }
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Move folder to correct parent
     */
    protected function moveFolderToParent($folderUri, $parentFolderUri)
    {
        try {
            $moveResponse = $this->vimeo->request($folderUri, [
                'parent_folder_uri' => $parentFolderUri
            ], 'PATCH');
            
            if (isset($moveResponse['body']['uri'])) {
                Log::info('Folder moved to correct parent');
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::warning('Failed to move folder: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Move video to folder
     */
    protected function moveVideoToFolder($videoUri, $folderUri)
    {
        try {
            $videoResponse = $this->vimeo->request($videoUri . '?fields=parent_folder');
            $currentParent = $videoResponse['body']['parent_folder']['uri'] ?? null;
            
            if ($currentParent !== $folderUri) {
                $moveResponse = $this->vimeo->request($videoUri, [
                    'folder_uri' => $folderUri
                ], 'PATCH');
                
                if (isset($moveResponse['body']['uri'])) {
                    Log::info('Video moved to folder successfully');
                } else {
                    Log::warning('Failed to move video to folder');
                }
            }
        } catch (\Exception $e) {
            Log::warning('Error moving video to folder: ' . $e->getMessage());
        }
    }

    /**
     * Get player URL from video URI
     */
    protected function getPlayerUrl($videoUri)
    {
        try {
            // Get embed code to extract hash parameter
            $response = $this->vimeo->request($videoUri . '?fields=embed.html');
            
            $videoId = str_replace('/videos/', '', $videoUri);
            $playerUrl = 'https://player.vimeo.com/video/' . $videoId;
            
            // Extract hash parameter from embed code if available
            $hash = null;
            if (isset($response['body']['embed']['html'])) {
                $embedHtml = $response['body']['embed']['html'];
                if (preg_match('/[?&]h=([^&]+)/', $embedHtml, $matches)) {
                    $hash = $matches[1];
                }
            }
            
            // Construct URL with template parameters
            $queryParams = [];
            if ($hash) {
                $queryParams[] = 'h=' . urlencode($hash);
            }
            $queryParams[] = 'title=0';
            $queryParams[] = 'byline=0';
            $queryParams[] = 'portrait=0';
            $queryParams[] = 'badge=0';
            $queryParams[] = 'autopause=0';
            $queryParams[] = 'player_id=0';
            $queryParams[] = 'app_id=58479';
            
            $playerUrl .= '?' . implode('&', $queryParams);
            
            return $playerUrl;
        } catch (\Exception $e) {
            // Fallback: return basic player URL
            $videoId = str_replace('/videos/', '', $videoUri);
            return 'https://player.vimeo.com/video/' . $videoId . '?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=58479';
        }
    }
}

