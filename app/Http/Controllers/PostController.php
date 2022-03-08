<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Report;
use App\Models\mylike;

class PostController extends Controller
{
    public function showMainPostControllerView(){
        return view ('posts.postmain');
    }

    public function showTimeline(Request $req,$major){
        $realMaj=$major;
        if($major=="korea"){
            $major="korean";
        }
        $count=($req->page)-1;
        $count=$count*10;
        $posts= file_get_contents("https://www.calamuseducation.com/calamus/api/posts/".$major."/?userId=10000&count=".$count);
         if($posts){
            $posts=json_decode($posts);
        }else{
            $posts=[];
        }
        
        return view('posts.timeline',[
            'posts'=>$posts,
            'page'=>$req->page,
            'major'=>$realMaj
        ]);
    }
    
    public function showCreatePost($major){
        return view('posts.createpost',[
            'major'=>$major
        ]);
    }

    public function uploadVimeo(Request $req){
          $req->validate([
            'post_id'=>'required'
            ]);
        $post_id=$req->post_id;
        $vimeo=$req->vimeo;
        
        post::where('post_id', $post_id)->update(['vimeo'=>$vimeo]);
        return back()->with('msg','Vimeo embedded');
    }
    
    public function addPost(Request $req,$major){
     
        $post_id=$req->post_id;
	    $learner_id=$req->learner_id;
	  
	    if(!empty($req->body)&&isset($req->body)){
	       $body=$req->body;
	    }else{
	        $body="";
	    }

        $imagePath="";
        $myPath="https://www.calamuseducation.com/uploads/";
        $file=$req->file('myfile');
        if(!empty($req->myfile)){
            $result=Storage::disk('calamusPost')->put('posts',$file);
            $imagePath=$myPath.$result;
        }
        
       $post=new post;
       $post->post_id=round(microtime(true) * 1000);
       $post->learner_id=10000;
       $post->body=$body;
       $post->image=$imagePath;
       $post->has_video=0;
       $post->major=$major;
       $post->post_like=0;
       $post->comments=0;
       $post->video_url="";
       $post->vimeo="";
       $post->view_count=0;
       $post->save();
        
        if($major=="korea"){
            $topic="koreaUsers";
        }else{
            $topic="englishUsers";
        }

        FirebaseNotiPushController::pushNotificationToTopic($topic,"New Calamus Post",$body);
        
        return back()->with('msg','Post was successfully added');
    }
    
    public function deletePost($postId){
  
        
        $image =post::where('post_id',$postId)->get();
        
        $image=$image[0]['image'];
        if($image!=""){
            $image = basename($image);
            $file=$_SERVER['DOCUMENT_ROOT'].'/uploads/posts/'.$image;
            if(file_exists($file)){
                unlink($file);
            }
        }
        $mylike=mylike::where('content_id',$postId)->delete();
        $notification=Notification::where('post_id',$postId)->delete();
        $comment = Comment::where('post_id', $postId)->delete();
        $report=Report::where('post_id',$postId)->delete();
        $post=post::where('post_id',$postId)->delete();
       
        return back()->with('msg','Successfully deleted');
    }
}
