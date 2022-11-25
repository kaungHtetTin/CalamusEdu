<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{
    
    // api for admin application
    public function fetchNotification(Request $req,$major){
    
    $mCode=$req->mCode;
    $user_id=$req->userId;
    
    $dataStore=$mCode."_user_datas";
    $notis=DB::table('notification')
        ->selectRaw("
                
                learners.learner_name as writer_name,
                learners.learner_image as writer_image,
        	    $dataStore.is_vip as vip,
        	    posts.post_id,
        	    posts.body,
        	    posts.image,
        	    posts.has_video,
        	    notification.id,
        	    notification.time,
        	    notification.seen,
        	    notification.action,
        	    notification.comment_id,
        	    notification_action.action_name as takingAction

            ")
        ->where('posts.major',$major)
        ->where('notification.owner_id',$user_id)
        ->where('notification.action','<',5)
        ->join('posts','posts.post_id','=','notification.post_id')
        ->join('learners','learners.learner_phone','=','notification.writer_id')
        ->join($dataStore,"$dataStore.phone",'=','learners.learner_phone')
        ->join('notification_action','notification_action.action','=','notification.action')
        ->orderBy('notification.time','desc')
        ->limit(200)
        ->get();
        return $notis;
        
    }
}
