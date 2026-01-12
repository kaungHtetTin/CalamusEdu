<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BloggerTestController extends Controller
{
    /**
     * Test and verify Blogger credentials
     */
    public function verifyCredentials()
    {
        try {
            // Get credentials directly without instantiating BloggerService
            // (which would fail if refresh token is invalid)
            $clientId = config('services.blogger.client_id');
            $clientSecret = config('services.blogger.client_secret');
            $refreshToken = config('services.blogger.refresh_token');
            $blogId = config('services.blogger.blog_id');

            if (!$clientId || !$clientSecret) {
                return response()->json([
                    'success' => false,
                    'error' => 'Client ID or Client Secret is missing in .env file',
                    'instructions' => [
                        '1. Check your .env file has:',
                        '   BLOGGER_CLIENT_ID=your_client_id',
                        '   BLOGGER_CLIENT_SECRET=your_client_secret',
                        '2. Make sure there are no extra spaces or quotes',
                        '3. Run: php artisan config:clear'
                    ]
                ], 400);
            }

            // Use Google Client directly to test credentials
            $testClient = new \Google\Client();
            $testClient->setClientId($clientId);
            $testClient->setClientSecret($clientSecret);
            $testClient->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
            $testClient->setAccessType('offline');
            $testClient->setApprovalPrompt('force');
            $testClient->addScope('https://www.googleapis.com/auth/blogger');

            $result = [
                'client_id_set' => !empty($clientId),
                'client_secret_set' => !empty($clientSecret),
                'refresh_token_set' => !empty($refreshToken),
                'blog_id_set' => !empty($blogId),
                'client_id' => substr($clientId, 0, 50) . '...', // Show first 50 chars for verification
                'client_id_length' => strlen($clientId ?? ''),
                'client_secret_length' => strlen($clientSecret ?? ''),
                'refresh_token_length' => strlen($refreshToken ?? ''),
                'refresh_token_preview' => substr($refreshToken, 0, 30) . '...',
                'credentials_valid' => false,
                'refresh_token_valid' => false,
                'auth_url' => null,
                'error' => null
            ];

            // Test if Client ID and Secret are valid by generating auth URL
            try {
                $authUrl = $testClient->createAuthUrl();
                $result['auth_url'] = $authUrl;
                $result['credentials_valid'] = true;
                $result['message'] = 'Client ID and Client Secret are valid!';
            } catch (\Exception $e) {
                $result['error'] = 'Client ID or Client Secret appears to be invalid: ' . $e->getMessage();
                return response()->json([
                    'success' => false,
                    'data' => $result,
                    'instructions' => [
                        'Client ID or Client Secret may be incorrect.',
                        'Verify in Google Cloud Console:',
                        '1. Go to https://console.cloud.google.com/',
                        '2. Select your project',
                        '3. Navigate to APIs & Services > Credentials',
                        '4. Check your OAuth 2.0 Client ID and Secret',
                        '5. Make sure Blogger API is enabled for your project'
                    ]
                ], 400);
            }

            // Test refresh token if provided
            if ($refreshToken) {
                try {
                    // Log first few characters for debugging (not the full token)
                    $tokenPreview = substr($refreshToken, 0, 20) . '...';
                    Log::info('Testing refresh token', ['token_preview' => $tokenPreview]);
                    
                    $tokenData = $testClient->fetchAccessTokenWithRefreshToken($refreshToken);
                    
                    if (isset($tokenData['error'])) {
                        $result['refresh_token_error'] = $tokenData['error'];
                        $result['refresh_token_error_description'] = $tokenData['error_description'] ?? 'Unknown error';
                        
                        // Provide specific guidance based on error
                        if ($tokenData['error'] === 'unauthorized_client') {
                            $result['error'] = 'Refresh token does not match Client ID/Secret. Make sure you used the EXACT same Client ID and Secret in OAuth Playground that are in your .env file.';
                            $result['solution'] = [
                                '1. Go to Google Cloud Console: https://console.cloud.google.com/apis/credentials',
                                '2. Find your OAuth 2.0 Client ID',
                                '3. Copy the Client ID and Client Secret',
                                '4. Go to OAuth Playground: https://developers.google.com/oauthplayground/',
                                '5. Click gear icon, check "Use your own OAuth credentials"',
                                '6. Paste the EXACT Client ID and Secret',
                                '7. Add redirect URI: https://developers.google.com/oauthplayground',
                                '8. In Google Cloud Console, add this redirect URI to your OAuth client',
                                '9. Then authorize and get refresh token again'
                            ];
                        } else {
                            $result['error'] = 'Refresh token error: ' . ($tokenData['error_description'] ?? $tokenData['error']);
                        }
                    } else {
                        $result['refresh_token_valid'] = true;
                        $result['access_token_obtained'] = isset($tokenData['access_token']);
                        $result['message'] = 'All credentials are valid and working!';
                        $result['error'] = null;
                    }
                } catch (\Exception $e) {
                    $result['refresh_token_error'] = $e->getMessage();
                    $result['error'] = 'Failed to verify refresh token: ' . $e->getMessage();
                }
            } else {
                $result['error'] = 'Refresh token is not set. Use OAuth Playground to get one.';
            }

            $response = [
                'success' => $result['credentials_valid'] && ($result['refresh_token_valid'] ?? false),
                'data' => $result
            ];

            // Add helpful instructions if there's an issue
            if (!$result['refresh_token_valid'] && $result['credentials_valid']) {
                $response['instructions'] = [
                    'Your Client ID and Secret are valid!',
                    'However, your refresh token is invalid or expired.',
                    '',
                    'IMPORTANT: Before using OAuth Playground, you MUST add the redirect URI:',
                    '',
                    'STEP 1: Add Redirect URI to Google Cloud Console',
                    '1. Go to: https://console.cloud.google.com/apis/credentials',
                    '2. Click on your OAuth 2.0 Client ID (the one with Client ID: ' . substr($clientId, 0, 30) . '...)',
                    '3. Under "Authorized redirect URIs", click "ADD URI"',
                    '4. Add: https://developers.google.com/oauthplayground',
                    '5. Click "SAVE"',
                    '',
                    'STEP 2: Generate New Refresh Token in OAuth Playground',
                    '1. Go to: https://developers.google.com/oauthplayground/',
                    '2. Click the gear icon (⚙️) in the top right corner',
                    '3. Check "Use your own OAuth credentials"',
                    '4. Enter Client ID: ' . $clientId,
                    '5. Enter Client Secret: ' . $clientSecret,
                    '6. In the left panel, find and select: "Blogger API v3"',
                    '7. Select scope: https://www.googleapis.com/auth/blogger',
                    '8. Click "Authorize APIs" button',
                    '9. Sign in with your Google account and grant permissions',
                    '10. Click "Exchange authorization code for tokens"',
                    '11. Copy the "Refresh token" value (starts with 1//...)',
                    '12. Update your .env file: BLOGGER_REFRESH_TOKEN=your_new_refresh_token',
                    '13. Run: php artisan config:clear',
                    '14. Test again: ' . url('/blogger/verify')
                ];
            }

            return response()->json($response, $response['success'] ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Get authorization URL
     */
    public function getAuthUrl()
    {
        try {
            $clientId = config('services.blogger.client_id');
            $clientSecret = config('services.blogger.client_secret');

            if (!$clientId || !$clientSecret) {
                return response()->json([
                    'success' => false,
                    'error' => 'Client ID or Client Secret is missing'
                ], 400);
            }

            $authClient = new \Google\Client();
            $authClient->setClientId($clientId);
            $authClient->setClientSecret($clientSecret);
            $authClient->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
            $authClient->setAccessType('offline');
            $authClient->setApprovalPrompt('force');
            $authClient->addScope('https://www.googleapis.com/auth/blogger');

            $authUrl = $authClient->createAuthUrl();

            return response()->json([
                'success' => true,
                'auth_url' => $authUrl,
                'note' => 'Note: Google has deprecated the out-of-band (OOB) flow. Please use Google OAuth 2.0 Playground instead.',
                'instructions' => [
                    'Google OAuth 2.0 Playground Method (Recommended):',
                    '1. Go to: https://developers.google.com/oauthplayground/',
                    '2. Click the gear icon (⚙️) in the top right corner',
                    '3. Check "Use your own OAuth credentials"',
                    '4. Enter your Client ID: ' . config('services.blogger.client_id'),
                    '5. Enter your Client Secret: ' . config('services.blogger.client_secret'),
                    '6. In the left panel, find "Blogger API v3"',
                    '7. Select scope: https://www.googleapis.com/auth/blogger',
                    '8. Click "Authorize APIs"',
                    '9. Sign in and grant permissions',
                    '10. Click "Exchange authorization code for tokens"',
                    '11. Copy the "Refresh token" value',
                    '12. Add to .env: BLOGGER_REFRESH_TOKEN=your_refresh_token',
                    '13. Run: php artisan config:clear'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exchange authorization code for tokens
     */
    public function exchangeCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        try {
            $clientId = config('services.blogger.client_id');
            $clientSecret = config('services.blogger.client_secret');

            if (!$clientId || !$clientSecret) {
                return response()->json([
                    'success' => false,
                    'error' => 'Client ID or Client Secret is missing'
                ], 400);
            }

            $authClient = new \Google\Client();
            $authClient->setClientId($clientId);
            $authClient->setClientSecret($clientSecret);
            $authClient->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
            $authClient->setAccessType('offline');
            $authClient->setApprovalPrompt('force');
            $authClient->addScope('https://www.googleapis.com/auth/blogger');

            $tokenData = $authClient->fetchAccessTokenWithAuthCode($request->code);

            if (isset($tokenData['error'])) {
                throw new \Exception('Failed to exchange code: ' . ($tokenData['error_description'] ?? $tokenData['error']));
            }

            return response()->json([
                'success' => true,
                'message' => 'Tokens obtained successfully!',
                'data' => [
                    'refresh_token' => $tokenData['refresh_token'] ?? 'Not provided (token may be cached)',
                    'access_token' => isset($tokenData['access_token']) ? 'Set (hidden for security)' : 'Not set',
                    'expires_in' => $tokenData['expires_in'] ?? 'Unknown',
                    'token_type' => $tokenData['token_type'] ?? 'Unknown'
                ],
                'instructions' => [
                    'Copy the refresh_token value and add it to your .env file:',
                    'BLOGGER_REFRESH_TOKEN=' . ($tokenData['refresh_token'] ?? 'YOUR_REFRESH_TOKEN_HERE')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
