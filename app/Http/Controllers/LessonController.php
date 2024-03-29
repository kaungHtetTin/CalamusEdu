<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lesson;
use App\Models\post;
use App\Models\mylike;
use App\Models\Studyplan;
use App\Models\Notification;
use App\Models\LessonCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function showLessonMain(){
     
        return view('lessons.lessonmain');
    }


    public function showLessonCategory($form){
        $major=$form;

        $courses=DB::table('courses')
        ->selectRaw('*')
        ->join('lessons_categories','lessons_categories.course_id','=','courses.course_id')
        ->where('lessons_categories.major',$major)
        ->get();

        $i=0;
        foreach($courses as $course){
            $arr[$course->course_id]['title']=$course->title;
            $arr[$course->course_id]['data'][]=$course;

             
        }
        
        return view('lessons.lessons',[
            'form'=>$form,
            'major'=>$major,
            'myCourses'=>$arr
        ]);
    }

    public function showLessonList(Request $req,$category_id){

        $lessons=lesson::where('category_id',$category_id)
        ->orderBy('isVideo','desc')
        ->orderBy('id')
        ->get();

        $category=LessonCategory::where('id',$category_id)->first();
        return view('lessons.lessonlist',[
            'lessons'=>$lessons,
            'category_id'=>$category_id,
            'cate'=>$req->cate,
            'icon'=>$category->image_url
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
        	    posts.video_url,
        	    posts.vimeo
        	    
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
            'title_mini'=>'required',
            'title'=>'required',
            'link'=>'required',
            'post'=>'required',
            'cate'=>'required'
        ]);
        
       
        $title_mini=$req->title_mini;
        $title=$req->title;
        $link=$req->link;
        $body=$req->post;
        $categoryId=$req->cate;
        $isVideo=(isset($req->isVideo))?1:0;
        $isChannel=(isset($req->isChannel))?1:0;
        $isVip=(isset($req->isVip))?1:0;
        $add_to_discuss=(isset($req->add_to_discuss))?0:1;
        $date = round(microtime(true) * 1000);
        $major=$req->major;
        
        if($isChannel==1){
            LessonCategory::where('id', $categoryId)->update(['sort_order'=>$date]);
        }
 
        
        $course_id=DB::table('courses')
            ->selectRaw("courses.course_id")
            ->join("lessons_categories","courses.course_id","=","lessons_categories.course_id")
            ->join("lessons","lessons_categories.id","=","lessons.category_id")
            ->where("lessons.category_id",$categoryId)->limit(1)->get();
            
        if(count($course_id)==1){
            $course_id= $course_id[0]->course_id;
            
            DB::table('courses')->where('course_id',$course_id)->update([
                'lessons_count'=>DB::raw("lessons_count+1")
            ]);
                   
        } 
            
            
        $imagePath="";
        $vimeo="";
    
        $isVideoLesson=0;
        
        if(isset($req->isVideo)){
            $vimeo=$req->vimeo;
            $myPath="https://www.calamuseducation.com/uploads/";
            $file=$req->file('myfile');
            if(!empty($req->myfile)){
                $result=Storage::disk('calamusPost')->put('posts',$file);
                $imagePath=$myPath.$result;
            }
            
            if($isVip==1){
                $isVideo=0; // for post
            }
            
             $isVideoLesson=1; // for lesson
            
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
        }else if($major=='english'){
            $noti_owner="1002";
        }else if($major=='chinese'){
            $noti_owner="1003";
        }else if($major=="japanese"){
            $noti_owner="1004";
        }
    
    
        $lesson=new lesson;
        $lesson->cate="";
        $lesson->category_id=$categoryId;
        $lesson->date=$date;
        $lesson->isVideo=$isVideoLesson;
        $lesson->isVip=$isVip;
        $lesson->isChannel=$isChannel;
        $lesson->link=$link;
        $lesson->title=$title;
        $lesson->title_mini=$title_mini;
        $lesson->major=$major;
        $lesson->thumbnail=$imagePath;
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
        $post->vimeo=$vimeo;
        $post->view_count=0;
        $post->major=$major;
        $post->hide=$add_to_discuss;
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
        }else if($req->major=="english"){
            $topic="englishUsers";
        }else if($req->major=="chinese"){
            $topic="chineseUsers";
        }else if($req->major=="japanese"){
            $topic="japaneseUsers";
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
    
    public function addLessonToStudyPlan(Request $req){
        
        // $req->validate([
        //     'day'=>'required'
        //     ]);
        $lesson_id=$req->id;
        $day=$req->day;
        $duration=$req->duration;
        
     
        
        if($day!=null){
            $course_id=DB::table('courses')
                ->selectRaw("courses.course_id")
                ->join("lessons_categories","courses.course_id","=","lessons_categories.course_id")
                ->join("lessons","lessons_categories.id","=","lessons.category_id")
                ->where("lessons.id",$lesson_id)->limit(1)->get();
             $course_id= $course_id[0]->course_id;
            
            $studyplan=new Studyplan();
            $studyplan->course_id=$course_id;
            $studyplan->lesson_id=$lesson_id;
            $studyplan->day=$day;
            $studyplan->save();
        }
        
        if($duration!=null){
            lesson::where('id', $lesson_id)->update(['duration'=>$duration]);
        }
      
        
        return back()->with('msg','Success');
    }

    public function updateVideoDuration(Request $req){
        
        $date=$req->date;
        $duration=$req->duration;
        lesson::where('date', $date)->update(['duration'=>$duration]);

    }
 
}
