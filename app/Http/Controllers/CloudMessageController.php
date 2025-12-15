<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CloudMessageController extends Controller
{
    public function showCloudMessage(){
        return view('cloudmessaging.cloudmessaging');
    }

    public function sendCloudMessage(Request $req){
        $req->validate([
            'title'=>'required',
            'msg'=>'required'
        ]);

        $title=$req->title;
        $msg=$req->msg;
        $topic=$req->app;
        $payload = array();
        $payload['team'] = 'Calamus';
        $payload['go'] = "cloud_message";
        
        FirebaseNotiPushController::pushNotificationToTopic($topic,$title,$msg,$payload);

        return back()->with('msg','Cloud message sent.');
    }
}
