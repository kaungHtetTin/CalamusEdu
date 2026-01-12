<?php

namespace App\Services;

use Google\Client;
use Illuminate\Support\Facades\Log;

class BloggerService
{
    protected $client;
    protected $blogId;

    public function __construct()
    {
        $clientId = config('services.blogger.client_id');
        $clientSecret = config('services.blogger.client_secret');
        $refreshToken = config('services.blogger.refresh_token');
        $this->blogId = config('services.blogger.blog_id');

        if (!$clientId || !$clientSecret || !$refreshToken || !$this->blogId) {
            throw new \Exception('Blogger credentials are not configured. Please add BLOGGER_CLIENT_ID, BLOGGER_CLIENT_SECRET, BLOGGER_REFRESH_TOKEN, and BLOGGER_BLOG_ID to your .env file.');
        }

        $this->client = new Client();
        $this->client->setClientId($clientId);
        $this->client->setClientSecret($clientSecret);
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt('force');
        $this->client->addScope('https://www.googleapis.com/auth/blogger');

        // Authenticate using refresh token
        try {
            // Fetch access token using refresh token
            $tokenData = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
            
            if (isset($tokenData['error'])) {
                $errorMsg = $tokenData['error_description'] ?? $tokenData['error'];
                $errorCode = $tokenData['error'] ?? 'unknown_error';
                
                // Provide specific guidance based on error type
                $userMessage = 'Failed to obtain access token: ' . $errorMsg;
                
                if ($errorCode === 'unauthorized_client') {
                    $userMessage .= '. The refresh token does not match your Client ID/Secret. Make sure you generated the refresh token using the EXACT same Client ID and Secret that are in your .env file.';
                } elseif ($errorCode === 'invalid_grant') {
                    $userMessage .= '. The refresh token is invalid or expired. Please generate a new refresh token using Google OAuth 2.0 Playground.';
                } else {
                    $userMessage .= '. Please verify that your BLOGGER_REFRESH_TOKEN, BLOGGER_CLIENT_ID, and BLOGGER_CLIENT_SECRET are correct.';
                }
                
                Log::error('Blogger authentication failed', [
                    'error' => $errorCode,
                    'error_description' => $errorMsg,
                    'client_id' => substr($clientId, 0, 30) . '...',
                    'client_id_length' => strlen($clientId ?? ''),
                    'client_secret_length' => strlen($clientSecret ?? ''),
                    'refresh_token_length' => strlen($refreshToken ?? ''),
                    'refresh_token_preview' => substr($refreshToken, 0, 20) . '...'
                ]);
                
                throw new \Exception($userMessage);
            }
            
            // Set the access token
            $this->client->setAccessToken($tokenData);
            
            // Verify access token is set
            $accessToken = $this->client->getAccessToken();
            if (!$accessToken || !isset($accessToken['access_token'])) {
                throw new \Exception('Access token was not properly set');
            }
            
            Log::info('Blogger authentication successful', [
                'has_access_token' => isset($accessToken['access_token']),
                'expires_in' => $accessToken['expires_in'] ?? 'unknown'
            ]);
            
        } catch (\Exception $e) {
            // If it's already our formatted exception, re-throw it
            if (strpos($e->getMessage(), 'Failed to obtain access token') === 0 || 
                strpos($e->getMessage(), 'Blogger authentication failed') === 0) {
                throw $e;
            }
            
            Log::error('Blogger authentication error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Blogger authentication failed: ' . $e->getMessage());
        }
    }

    /**
     * Verify and test OAuth credentials
     * 
     * @return array Array with verification results
     * @throws \Exception
     */
    public function verifyCredentials(): array
    {
        $clientId = config('services.blogger.client_id');
        $clientSecret = config('services.blogger.client_secret');
        $refreshToken = config('services.blogger.refresh_token');
        $blogId = config('services.blogger.blog_id');

        $result = [
            'client_id_set' => !empty($clientId),
            'client_secret_set' => !empty($clientSecret),
            'refresh_token_set' => !empty($refreshToken),
            'blog_id_set' => !empty($blogId),
            'client_id_length' => strlen($clientId ?? ''),
            'client_secret_length' => strlen($clientSecret ?? ''),
            'refresh_token_length' => strlen($refreshToken ?? ''),
            'client_id_format' => $this->checkClientIdFormat($clientId),
            'client_secret_format' => $this->checkClientSecretFormat($clientSecret),
            'auth_url' => null,
            'error' => null,
            'credentials_valid' => false,
            'refresh_token_valid' => false
        ];

        if (!$clientId || !$clientSecret) {
            $result['error'] = 'Client ID or Client Secret is missing';
            return $result;
        }

        try {
            // Create a test client to verify credentials format
            $testClient = new Client();
            $testClient->setClientId($clientId);
            $testClient->setClientSecret($clientSecret);
            $testClient->setRedirectUri('urn:ietf:wg:oauth:2.0:oob'); // For testing
            $testClient->setAccessType('offline');
            $testClient->setApprovalPrompt('force');
            $testClient->addScope('https://www.googleapis.com/auth/blogger');

            // Generate authorization URL - if this works, Client ID and Secret are valid
            try {
                $authUrl = $testClient->createAuthUrl();
                $result['auth_url'] = $authUrl;
                $result['credentials_valid'] = true;
                $result['message'] = 'Client ID and Client Secret appear to be valid. Authorization URL generated successfully.';
            } catch (\Exception $e) {
                $result['error'] = 'Client ID or Client Secret may be invalid: ' . $e->getMessage();
                return $result;
            }

            // If refresh token is provided, try to use it
            if ($refreshToken) {
                try {
                    $tokenData = $testClient->fetchAccessTokenWithRefreshToken($refreshToken);
                    
                    if (isset($tokenData['error'])) {
                        $result['refresh_token_error'] = $tokenData['error'];
                        $result['refresh_token_error_description'] = $tokenData['error_description'] ?? 'Unknown error';
                        
                        if ($tokenData['error'] === 'invalid_grant' || strpos(strtolower($tokenData['error'] ?? ''), 'unauthorized') !== false) {
                            $result['error'] = 'Refresh token is invalid, expired, or does not match the Client ID/Secret. You need to generate a new refresh token using the authorization URL above.';
                            $result['solution'] = 'Use the auth_url to authorize and get a new refresh token.';
                        } else {
                            $result['error'] = 'Refresh token error: ' . ($tokenData['error_description'] ?? $tokenData['error']);
                        }
                    } else {
                        $result['refresh_token_valid'] = true;
                        $result['access_token_obtained'] = isset($tokenData['access_token']);
                        $result['message'] = 'All credentials are valid! Refresh token works correctly.';
                        $result['error'] = null;
                    }
                } catch (\Exception $e) {
                    $result['refresh_token_error'] = $e->getMessage();
                    $result['error'] = 'Failed to verify refresh token: ' . $e->getMessage();
                }
            } else {
                $result['error'] = 'Refresh token is not set. Use the authorization URL above to get one.';
                $result['solution'] = 'Follow the auth_url to authorize and get a refresh token.';
            }

        } catch (\Exception $e) {
            $result['error'] = 'Credential verification failed: ' . $e->getMessage();
        }

        return $result;
    }

    /**
     * Check if Client ID format looks valid
     */
    protected function checkClientIdFormat(?string $clientId): string
    {
        if (empty($clientId)) {
            return 'empty';
        }
        
        // Google Client IDs typically end with .apps.googleusercontent.com or are numeric
        if (strpos($clientId, '.apps.googleusercontent.com') !== false) {
            return 'valid_format';
        }
        
        if (preg_match('/^\d+-\w+\.apps\.googleusercontent\.com$/', $clientId)) {
            return 'valid_format';
        }
        
        return 'unusual_format';
    }

    /**
     * Check if Client Secret format looks valid
     */
    protected function checkClientSecretFormat(?string $clientSecret): string
    {
        if (empty($clientSecret)) {
            return 'empty';
        }
        
        // Google Client Secrets are typically long alphanumeric strings
        if (strlen($clientSecret) >= 20) {
            return 'valid_length';
        }
        
        return 'short_length';
    }

    /**
     * Get authorization URL for OAuth flow
     * 
     * @param string|null $redirectUri Optional redirect URI (default: urn:ietf:wg:oauth:2.0:oob)
     * @return string Authorization URL
     */
    public function getAuthorizationUrl(?string $redirectUri = null): string
    {
        $clientId = config('services.blogger.client_id');
        $clientSecret = config('services.blogger.client_secret');

        if (!$clientId || !$clientSecret) {
            throw new \Exception('Client ID and Client Secret must be configured');
        }

        $authClient = new Client();
        $authClient->setClientId($clientId);
        $authClient->setClientSecret($clientSecret);
        $authClient->setRedirectUri($redirectUri ?? 'urn:ietf:wg:oauth:2.0:oob');
        $authClient->setAccessType('offline');
        $authClient->setApprovalPrompt('force');
        $authClient->addScope('https://www.googleapis.com/auth/blogger');

        return $authClient->createAuthUrl();
    }

    /**
     * Exchange authorization code for refresh token
     * 
     * @param string $authCode Authorization code from OAuth callback
     * @param string|null $redirectUri Optional redirect URI (must match the one used in authorization)
     * @return array Token data including refresh_token
     */
    public function exchangeCodeForTokens(string $authCode, ?string $redirectUri = null): array
    {
        $clientId = config('services.blogger.client_id');
        $clientSecret = config('services.blogger.client_secret');

        if (!$clientId || !$clientSecret) {
            throw new \Exception('Client ID and Client Secret must be configured');
        }

        $authClient = new Client();
        $authClient->setClientId($clientId);
        $authClient->setClientSecret($clientSecret);
        $authClient->setRedirectUri($redirectUri ?? 'urn:ietf:wg:oauth:2.0:oob');
        $authClient->setAccessType('offline');
        $authClient->setApprovalPrompt('force');
        $authClient->addScope('https://www.googleapis.com/auth/blogger');

        $tokenData = $authClient->fetchAccessTokenWithAuthCode($authCode);

        if (isset($tokenData['error'])) {
            throw new \Exception('Failed to exchange code: ' . ($tokenData['error_description'] ?? $tokenData['error']));
        }

        return $tokenData;
    }

    /**
     * Create a blog post with HTML content
     * 
     * @param string $title Post title
     * @param string $htmlContent HTML content of the post
     * @param bool $published Whether to publish immediately (default: true)
     * @param array|null $labels Optional array of labels (tags) for the post
     * @return array Array containing 'postId', 'url', and 'feedUrl'
     * @throws \Exception
     */
    public function createPost(string $title, string $htmlContent, bool $published = true, ?array $labels = null): array
    {
        try {
            // Verify client is authenticated
            $accessToken = $this->client->getAccessToken();
            if (!$accessToken || isset($accessToken['error'])) {
                throw new \Exception('Client is not authenticated. Access token is missing or invalid.');
            }
            
            // Use service discovery to get Blogger service
            $blogger = new \Google\Service\Blogger($this->client);
            
            $post = new \Google\Service\Blogger\Post();
            $post->setTitle($title);
            $post->setContent($htmlContent);
            
            // Set labels if provided
            if ($labels !== null && !empty($labels)) {
                $post->setLabels($labels);
            }
            
            if ($published) {
                $post->setPublished(date('c')); // ISO 8601 format
            }

            $createdPost = $blogger->posts->insert($this->blogId, $post);

            $postId = $createdPost->getId();
            $url = $createdPost->getUrl();
            
            // Convert to feed URL format: https://www.blogger.com/feeds/{blogId}/posts/default/{postId}?alt=json
            $feedUrl = "https://www.blogger.com/feeds/{$this->blogId}/posts/default/{$postId}?alt=json";

            Log::info('Blogger post created successfully', [
                'post_id' => $postId,
                'url' => $url,
                'feed_url' => $feedUrl
            ]);

            return [
                'postId' => $postId,
                'url' => $url,
                'feedUrl' => $feedUrl
            ];

        } catch (\Exception $e) {
            Log::error('Blogger post creation error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new \Exception('Blogger post creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing blog post
     * 
     * @param string $postId Post ID
     * @param string $title Post title
     * @param string $htmlContent HTML content of the post
     * @param array|null $labels Optional array of labels (tags) for the post
     * @return array Array containing 'postId', 'url', and 'feedUrl'
     * @throws \Exception
     */
    public function updatePost(string $postId, string $title, string $htmlContent, ?array $labels = null): array
    {
        try {
            $blogger = new \Google\Service\Blogger($this->client);
            $post = $blogger->posts->get($this->blogId, $postId);
            $post->setTitle($title);
            $post->setContent($htmlContent);
            
            // Set labels if provided
            if ($labels !== null && !empty($labels)) {
                $post->setLabels($labels);
            }

            $updatedPost = $blogger->posts->update($this->blogId, $postId, $post);

            $url = $updatedPost->getUrl();
            $feedUrl = "https://www.blogger.com/feeds/{$this->blogId}/posts/default/{$postId}?alt=json";

            Log::info('Blogger post updated successfully', [
                'post_id' => $postId,
                'url' => $url,
                'feed_url' => $feedUrl
            ]);

            return [
                'postId' => $postId,
                'url' => $url,
                'feedUrl' => $feedUrl
            ];

        } catch (\Exception $e) {
            Log::error('Blogger post update error', [
                'message' => $e->getMessage(),
                'post_id' => $postId
            ]);

            throw new \Exception('Blogger post update failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete a blog post
     * 
     * @param string $postId Post ID
     * @return bool True if successful
     * @throws \Exception
     */
    public function deletePost(string $postId): bool
    {
        try {
            $blogger = new \Google\Service\Blogger($this->client);
            $blogger->posts->delete($this->blogId, $postId);

            Log::info('Blogger post deleted successfully', [
                'post_id' => $postId
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Blogger post deletion error', [
                'message' => $e->getMessage(),
                'post_id' => $postId
            ]);

            return false;
        }
    }
}
