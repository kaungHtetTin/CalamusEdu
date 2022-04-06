<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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

        $dataStore=$req->mCode;
        $page=$req->page;
        
        $limit=10;
        $count=($page-1)*$limit;
        
        $dataStore=$dataStore."_user_datas";

        $posts=DB::table('posts')
            ->selectRaw("
                    learners.learner_name as userName,
            	    learners.learner_phone as userId,
            	    $dataStore.token as userToken,
            	    learners.learner_image as userImage,
            	    $dataStore.is_vip as vip,
            	    posts.post_id as postId,
            	    posts.body as body,
            	    posts.post_like as postLikes,
            	    posts.comments,
            	    posts.image as postImage,
            	    posts.view_count as viewCount,
                    posts.vimeo,
            	    posts.has_video
            	    
                ")
            ->where('posts.major',$major)
            ->join('learners','learners.learner_phone','=','posts.learner_id')
            ->join($dataStore,"$dataStore.phone",'=','posts.learner_id')
            ->orderBy('posts.id','desc')
            ->offset($count)
            ->limit($limit)
            ->get();
        
        if(!sizeof($posts)==0){
            
            foreach($posts as $post){
                
                $post->is_liked=0;
                $likeRows=mylike::where('content_id',$post->postId)->get();
                
                foreach ($likeRows as $row){
                
                        $likesArr=json_decode($row->likes,true);
                
                        $user_ids=array_column($likesArr,"user_id");
                        
                    if(in_array( 10000, $user_ids)){
                        $post->is_liked=1;
                        
                    }
                }
                    $arr[]=$post;
            
            }
           
           
                
        }else{
             $arr=null;
        }
        
        return view('posts.timeline',[
            'posts'=>$arr,
            'mCode'=>$req->mCode,
            'page'=>$req->page,
            'major'=>$req->major
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



    //api function


    public function fetchMorePost(Request $req,$major){

        $dataStore=$req->mCode;
        $page=$req->page;
        
        $limit=10;
        $count=($page-1)*$limit;
        
        $dataStore=$dataStore."_user_datas";

        $posts=DB::table('posts')
            ->selectRaw("
                    learners.learner_name as userName,
            	    learners.learner_phone as userId,
            	    $dataStore.token as userToken,
            	    learners.learner_image as userImage,
            	    $dataStore.is_vip as vip,
            	    posts.post_id as postId,
            	    posts.body as body,
            	    posts.post_like as postLikes,
            	    posts.comments,
            	    posts.image as postImage,
            	    posts.view_count as viewCount,
                    posts.vimeo,
            	    posts.has_video
            	    
                ")
            ->where('posts.major',$major)
            ->join('learners','learners.learner_phone','=','posts.learner_id')
            ->join($dataStore,"$dataStore.phone",'=','posts.learner_id')
            ->orderBy('posts.id','desc')
            ->offset($count)
            ->limit($limit)
            ->get();
        
        if(!sizeof($posts)==0){
            
            foreach($posts as $post){
                
                $post->is_liked=0;
                $likeRows=mylike::where('content_id',$post->postId)->get();
                
                foreach ($likeRows as $row){
                
                        $likesArr=json_decode($row->likes,true);
                
                        $user_ids=array_column($likesArr,"user_id");
                        
                    if(in_array( 10000, $user_ids)){
                        $post->is_liked=1;
                        
                    }
                }
                    $arr[]=$post;
            
            }
           
           
                
        }else{
             $arr=null;
        }

        
        return $arr;
        
    }
}
