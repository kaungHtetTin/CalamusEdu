<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseNotiPushController extends Controller
{
   
    public static function pushNotificationToSingleUser($to,$title,$message){
    
        $payload = array();
        $payload['team'] = 'Calamus';
        $payload['go'] = "cloud_message";
        
        $messagePayload = [
            'message' => [
                'token' => $to,
                'notification' => [
                    'title' => $title,
                    'body' => $message
                ],
                'data' => [
                    'title' => $title,
                    'is_background'=>"FALSE",
                    'message' => $message,
                    'image'=> "",
                    'payload'=> json_encode($payload),
                    'timestamp'=>date('Y-m-d G:i:s'),
                ]
            ]
        ];
        
        return FirebaseNotiPushController:: sendNotification($messagePayload);
    }

    public static function pushNotificationToTopic($to,$title,$message,$payload){
       
        if($to=='adminKorea'){
            $start_msg=substr($message,0,3);
            if($start_msg=="Dev"){
                $to="ekDeveloper";
            }
        }
        
        $messagePayload = [
            'message' => [
                'topic' => $to,
                'notification' => [
                    'title' => $title,
                    'body' => $message
                ],
                'data' => [
                    'title' => $title,
                    'is_background'=>"FALSE",
                    'message' => $message,
                    'image'=> "",
                    'payload'=> json_encode($payload),
                    'timestamp'=>date('Y-m-d G:i:s'),
                ]
            ]
        ];
        
        return FirebaseNotiPushController:: sendNotification($messagePayload);
    }


   public static function sendNotification($fields){
        
        $url = 'https://fcm.googleapis.com/v1/projects/learn-room/messages:send';
 
        $serviceAccountKeyPath = base_path("important-firebase-key.json");
   
        // Get Access Token
        $accessToken = self::getAccessToken($serviceAccountKeyPath);

        $headers = array(
            'Authorization: Bearer '. $accessToken,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
 
        return $result;
       // return $headers;
    }
    
    private static function getAccessToken($serviceAccountKeyPath) {
    // Check if file exists
        if (!file_exists($serviceAccountKeyPath)) {
            
            return "Service account key file not found: " . $serviceAccountKeyPath;
        }
        
        
        $serviceAccount = json_decode(file_get_contents($serviceAccountKeyPath), true);
        
        $jwtHeader = base64_encode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT'
        ]));
        
        $now = time();
        $jwtClaimSet = base64_encode(json_encode([
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ]));
        
        $jwtUnsigned = $jwtHeader . '.' . $jwtClaimSet;
        
        // Sign the JWT
        openssl_sign($jwtUnsigned, $signature, $serviceAccount['private_key'], 'SHA256');
        $jwtSignature = base64_encode($signature);
        
        $jwt = $jwtUnsigned . '.' . $jwtSignature;
        
        // Exchange JWT for access token
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://oauth2.googleapis.com/token',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        if ($httpCode == 200) {
            $tokenData = json_decode($response, true);
            return $tokenData['access_token'];
        } else {
            error_log("Failed to get access token. HTTP Code: " . $httpCode . " Response: " . $response);
            return null;
        }
    }
}
