<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseNotiPushController extends Controller
{
   
    public static function pushNotificationToSingleUser($to,$title,$message){
    
        $payload = array();
        $payload['team'] = 'Calamus';
        $payload['go'] = "Easy Korean";
        $res = array();
        $res['data']['title'] = $title;
        $res['data']['is_background'] =FALSE;
        $res['data']['message'] = $message;
        $res['data']['image'] = "";
        $res['data']['payload'] = $payload;
        $res['data']['timestamp'] = date('Y-m-d G:i:s');
        
        $fields = array(
            'to' => $to,
            'data' => $res,
        );
        return FirebaseNotiPushController:: sendNotification($fields);
    }

    public static function pushNotificationToTopic($to,$title,$message){
        $payload = array();
        $payload['team'] = 'Calamus';
        $payload['go'] = "Easy Korean";

        $res = array();
        $res['data']['title'] = $title;
        $res['data']['is_background'] =FALSE;
        $res['data']['message'] = $message;
        $res['data']['image'] = "";
        $res['data']['payload'] = $payload;
        $res['data']['timestamp'] = date('Y-m-d G:i:s');

        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $res,
        );
        return FirebaseNotiPushController:: sendNotification($fields);
    }


    public static function sendNotification($fields){
        $FIREBASE_API_KEY="AAAA2wIrZh4:APA91bFjeO13Fl10XsRQqV0lpgfqodOw0w8fZ0HgJu71BmxTymRBswaQpiOn-WxqQrAM_H8DQ3anHBhkheOjzdukkUQhFi94yZ_kbxUGZzP_iUqq6_s2KnM9vWGyJo7eMyQhHdAyOaQ3";
     
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array(
            'Authorization: key=' . $FIREBASE_API_KEY,
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
 
        return $headers;
    }
}
