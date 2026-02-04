<?php

namespace App\Services;

use Vimeo\Vimeo;
use Illuminate\Support\Facades\Log;

class VimeoService
{
    protected Vimeo $vimeo;

    public function __construct()
    {
        $clientId     = config('services.vimeo.client_id');
        $clientSecret = config('services.vimeo.client_secret');
        $accessToken  = config('services.vimeo.access_token');

        if (!$clientId || !$clientSecret || !$accessToken) {
            throw new \Exception('Vimeo credentials are not configured.');
        }

        $this->vimeo = new Vimeo($clientId, $clientSecret, $accessToken);
    }

    /**
     * Upload video directly to Vimeo (no projects/folders)
     * Uses pathSegments to build unique video name to avoid duplicates
     *
     * @param mixed $file The uploaded file
     * @param string $title Video title
     * @param array $pathSegments Array of path segments to build unique video name (e.g., ['Language', 'Course', 'Category'] or ['Language', 'Course', 'Preview'])
     * @return string Player URL
     * @throws \Exception
     */
    public function uploadVideo(
        $file,
        string $title,
        array $pathSegments
    ): string {
        try {
            // Build unique video name from title and path segments to avoid duplicates
            $videoName = $this->buildVideoName($title, $pathSegments);

            // Upload video directly (no project attachment)
            $videoUri = $this->vimeo->upload(
                $file->getRealPath(),
                [
                    'name'        => $videoName,
                    'description' => 'Uploaded via API'
                ]
            );

            if (!$videoUri) {
                throw new \Exception('Video upload failed.');
            }

            // Return player URL
            return $this->buildPlayerUrl($videoUri);

        } catch (\Exception $e) {
            Log::error('Vimeo upload error', [
                'message' => $e->getMessage(),
                'path_segments' => $pathSegments,
                'title' => $title
            ]);

            throw $e;
        }
    }

    /* =========================================================
       Video name handling
       ========================================================= */

    /**
     * Build unique video name from title and path segments
     * Format: "Title - Segment1 / Segment2 / Segment3"
     * 
     * @param string $title Video title
     * @param array $pathSegments Array of path segment strings
     * @return string Unique video name
     */
    protected function buildVideoName(string $title, array $pathSegments): string
    {
        // Filter out empty segments and trim each segment
        $cleanSegments = array_filter(
            array_map('trim', $pathSegments),
            function($segment) {
                return !empty($segment);
            }
        );

        // Capitalize first letter of first segment (typically language)
        if (!empty($cleanSegments)) {
            $cleanSegments = array_values($cleanSegments); // Re-index array
            $cleanSegments[0] = ucfirst($cleanSegments[0]);
        }

        // Build path string
        $pathString = implode(' / ', $cleanSegments);

        // Combine title with path segments to create unique name
        if (!empty($pathString)) {
            return trim($title . ' - ' . $pathString);
        }

        return trim($title);
    }

    /**
     * Delete video from Vimeo
     * 
     * @param string $playerUrlOrVideoId Player URL (e.g., "https://player.vimeo.com/video/123456?title=0...") or video ID (e.g., "123456") or video URI (e.g., "/videos/123456")
     * @return bool True if deletion was successful, false otherwise
     * @throws \Exception
     */
    public function deleteVideo(string $playerUrlOrVideoId): bool
    {
        try {
            // Extract video ID from various input formats
            $videoId = $this->extractVideoId($playerUrlOrVideoId);

            if (!$videoId) {
                Log::warning('Vimeo delete: Could not extract video ID', [
                    'input' => $playerUrlOrVideoId
                ]);
                return false;
            }

            // Build video URI
            $videoUri = "/videos/{$videoId}";

            // Delete video using Vimeo API
            $response = $this->vimeo->request($videoUri, [], 'DELETE');

            $statusCode = $response['status'] ?? 0;

            if ($statusCode >= 200 && $statusCode < 300) {
                Log::info('Vimeo video deleted successfully', [
                    'video_id' => $videoId,
                    'video_uri' => $videoUri
                ]);
                return true;
            } else {
                Log::warning('Vimeo delete failed', [
                    'video_id' => $videoId,
                    'status_code' => $statusCode,
                    'response' => $response
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Vimeo delete error', [
                'message' => $e->getMessage(),
                'input' => $playerUrlOrVideoId,
                'trace' => $e->getTraceAsString()
            ]);

            // Don't throw exception - return false to allow graceful handling
            return false;
        }
    }

    /* =========================================================
       Helper methods
       ========================================================= */

    /**
     * Extract video ID from various URL formats
     * 
     * @param string $input Player URL, video ID, or video URI
     * @return string|null Video ID or null if not found
     */
    protected function extractVideoId(string $input): ?string
    {
        if (empty($input)) {
            return null;
        }

        // If it's already just a numeric ID
        if (preg_match('/^\d+$/', trim($input))) {
            return trim($input);
        }

        // Extract from player URL: https://player.vimeo.com/video/123456?...
        if (preg_match('/player\.vimeo\.com\/video\/(\d+)/', $input, $matches)) {
            return $matches[1];
        }

        // Extract from vimeo.com URL: https://vimeo.com/123456
        if (preg_match('/vimeo\.com\/(\d+)/', $input, $matches)) {
            return $matches[1];
        }

        // Extract from video URI: /videos/123456
        if (preg_match('/\/videos\/(\d+)/', $input, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /* =========================================================
       Player URL
       ========================================================= */

    protected function buildPlayerUrl(string $videoUri): string
    {
        $videoId = basename($videoUri);
        return "https://player.vimeo.com/video/{$videoId}?h=73c9a3c891&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479";
    }
}
