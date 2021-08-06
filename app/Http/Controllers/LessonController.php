<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lesson;
use App\Models\post;
use App\Models\mylike;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function showLessonMain(){
     
        return view('lessons.lessonmain');
    }



    public function showLessonCategory($form){
        $major=$form;
        $form= file_get_contents("https://www.calamuseducation.com/calamus/api/form/".$form);
        return view('lessons.lessons',[
            'form'=>$form,
            'major'=>$major
        ]);
    }

    public function showLessonList(Request $req,$code){

        $lessons=lesson::where('cate',$code)
        ->where('major',$req->major)
        ->orderBy('isVideo','desc')
        ->get();
        return view('lessons.lessonlist',[
            'lessons'=>$lessons,
            'code'=>$code,
            'cate'=>$req->cate,
            'icon'=>session($code)
        ]);
    }

    public function viewVideoLesson($id){
        $lesson=lesson::find($id);

    
        $post=DB::table('posts')
        ->selectRaw("
               
        	    posts.post_like as postLikes,
        	    posts.post_id,
        	    posts.comments,
        	    posts.view_count,
        	    posts.video_url
        	    
            ")
        ->where('posts.post_id',$lesson->date)
        ->first();
              
        $post->is_liked=0;
        $likeRows=mylike::where('content_id',$post->post_id)->get();

        foreach ($likeRows as $row){
                     
            $likesArr=json_decode($row->likes,true);
            
            $user_ids=array_column($likesArr,"user_id");
                     
                if(in_array( "10000", $user_ids)){
                    $post->is_liked=1;
                        
                }
        }
            

        $comments=DB::table('comment')
	    ->selectRaw('
	        learners.learner_name as userName,
    	    learners.learner_image as userImage,
    	    comment.body,
    	    comment.time,
    	    comment.writer_id as userId
	        ')
	    ->where('comment.post_id',$lesson->date)
	    ->join('learners','learners.learner_phone','=','comment.writer_id')
	    ->join('ko_user_datas','ko_user_datas.phone','=','comment.writer_id')
	    ->orderBy('comment.time')
	    ->get();
        
        return view('lessons.videolesson',[
        'lesson'=>$lesson,
        'post'=>$post,
        'comments'=>$comments
        ]);
    }

    public function viewBlogLesson($id){
        $lesson=lesson::find($id);
        $lessonData=file_get_contents($lesson->link);
        $lessonData=json_decode($lessonData);
        return view('lessons.bloglesson',['lessonData'=>$lessonData]);
    }


   public function showAddLesson($course){
       return view('lessons.addlesson',[
           'course'=>$course
       ]);
   }

   public function addLesson(Request $req,$course){

        $req->validate([
            'title'=>'required',
            'link'=>'required',
            'post'=>'required',
            'cate'=>'required'
        ]);
        
        $title=$req->title;
        $link=$req->link;
        $body=$req->post;
        $cate=$req->cate;
        $isVideo=(isset($req->isVideo))?1:0;
        $isChannel=(isset($req->isChannel))?1:0;
        $isVip=(isset($req->isVip))?1:0;
        $date = round(microtime(true) * 1000);
        $major=$req->major;
    
        if(isset($req->isVideo)){
            $imagePath="https://img.youtube.com/vi/".$link."/0.jpg";
        }else{
            $imagePath="";
            $templink=$req->link;
            $templink=substr($templink,strpos($templink, "edit/")+5);
            $blogId=substr($templink,0,19);
            $blogPostId=substr($templink,20);
            $link="https://www.blogger.com/feeds/".$blogId."/posts/default/".$blogPostId."?alt=json";
            
        }
       
    
        if($major=='korea'){
            $noti_owner="1001";
        }else{
            $noti_owner="1002";
        }
    
    
        $lesson=new lesson;
        $lesson->cate=$cate;
        $lesson->date=$date;
        $lesson->isVideo=$isVideo;
        $lesson->isVip=$isVip;
        $lesson->isChannel=$isChannel;
        $lesson->link=$link;
        $lesson->title=$title;
        $lesson->major=$major;
        $lesson->save();
        
        $post=new post;
        $post->post_id=$date;
        $post->learner_id=10000;
        $post->body=$body;
        $post->post_like=0;
        $post->comments=0;
        $post->image=$imagePath;
        $post->video_url="";
        $post->has_video=$isVideo;
        $post->view_count=0;
        $post->major=$major;
        $post->save();
    
        $notification=new Notification;
        $notification->post_id=$date;
        $notification->comment_id=0;
        $notification->owner_id=$noti_owner;
        $notification->writer_id='10000';
        $notification->action=2;
        $notification->time=$date;
        $notification->seen=2;
        $notification->save();

        if($req->major=="korea"){
            $topic="koreaUsers";
        }else{
            $topic="englishUsers";
        }

        FirebaseNotiPushController::pushNotificationToTopic($topic,"New Lesson",$body);
        
        return back()->with('msgLesson','Lesson was successfully added');

    }
    
    public function uploadVideoForLessonDownload(Request $req){
        $req->validate([
            'myfile'=>'required'
            ]);
        
        $post_id=$req->postid;
        $myPath="https://www.calamuseducation.com/uploads/";
        $file=$req->file('myfile');
        $result=Storage::disk('calamusPost')->put('videos',$file);
        $url=$myPath.$result;
        post::where('post_id', $post_id)->update(['video_url'=>$url]);
        return back()->with('msg','Video was successfully added');
    }
}
