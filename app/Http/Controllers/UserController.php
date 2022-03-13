<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\learner;
use App\Models\EasyKoreanUserData;
use App\Models\EasyEnglishUserData;
use App\Models\VipUser;
use App\Models\course;
use Illuminate\Support\Facades\DB;
use Hash;
use Validator;


class UserController extends Controller
{
    public function getUser(){
        $learners=learner::orderBy('id','desc')->simplepaginate(20);
        $learner_count=learner::get()->count();
        $korean_user_count=EasyKoreanUserData::get()->count();
        $english_user_count=EasyEnglishUserData::get()->count();

        return view('userlayouts.user',[
            'learners'=>$learners,
            'learner_count'=>$learner_count,
            'koeran_user_count'=>$korean_user_count,
            'english_user_count'=>$english_user_count
        ]);
    }

    public function searchUser(Request $req){
        $phone=$req->phone;
        $message=$req->msg;
        $learner=learner::where('learner_phone',$phone)->first();
        $easykorean=EasyKoreanUserData::where('phone',$phone)->first();
        $easyenglish=EasyEnglishUserData::where('phone',$phone)->first();
        return view('userlayouts.userdetail',[
            'learner'=>$learner,
            'easykorean'=>$easykorean,
            'easyenglish'=>$easyenglish
        ]);
    }

    public function showPasswordReset(Request $req ,$phone){
        $learner=learner::where('learner_phone',$phone)->first();
        return view('userlayouts.passwordreset',[
            'learner'=>$learner,
        ]);
    }

    public function resetPassword(Request $req){

        $req->validate([
            'password' => 'required',
          ]);

        $phone=$req->phone;
        $password=Hash::make($req->password);

        $reseting=learner::where('learner_phone',$phone)->update([
            'password'=>$password
        ]);

        if($reseting){
           return redirect(route('showPasswordReset',$phone))->with('resetSuccess','Password successfully reset');
        }else{
            return redirect(route('showPasswordReset',$phone))->with('resetErr','Password successfully reset');
        }
      

    }
    
    public function easyEnglishUserDatas(){
        $users=DB::table('ee_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ee_user_datas.phone','=','learners.learner_phone')
            ->orderBy('ee_user_datas.id','desc')
            ->simplepaginate(100);
        $counts=EasyEnglishUserData::count();
      
        return view('userlayouts.englishuser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
    }


    public function easyKoreanUserDatas(){
        $users=DB::table('ko_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ko_user_datas.phone','=','learners.learner_phone')
            ->orderBy('ko_user_datas.id','desc')
            ->simplepaginate(100);
        $counts=EasyKoreanUserData::count();
        return view('userlayouts.koreauser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
    }


    public function showSendEmail($id){
        $learner=learner::find($id);
        return view('userlayouts.emailsending',[
            'learner'=>$learner
        ]);
    }
    
    public function sendEmail(Request $req){
        $req->validate([
            'email'=>'required',
            'msg'=>'required',  
            'subject'=>'required',  
            'header'=>'required' 
        
        ]);
        
        if(mail($req->email,$req->subject,$req->msg,$req->header)){
            return back()->with('msg','Sent');
        }else{
            
        }  return back()->with('err','Error!');
      
    }
    
    public function filterEnglishUser(Request $req){
        $row=$req->sqlrow;
        $count=$req->count==null?1:$req->count;
        $isVip=$req->vip=="on"?true:false;
        $lastDate=$req->ago==null?"0000-00-00":(date("Y-m-d",strtotime("-".$req->ago." days")));
      
        if($isVip){
            $users=DB::table('ee_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ee_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('is_vip',true)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyEnglishUserData::where($row,'>=',$count) ->where('last_active','>=',$lastDate)->where('is_vip',true)->count();
        }else{
            $users=DB::table('ee_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ee_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyEnglishUserData::where($row,'>=',$count)->where('last_active','>=',$lastDate)->count();
        }
       
        return view('userlayouts.englishuser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
      
      
    }
    
    public function filterKoreaUser(Request $req){
        $row=$req->sqlrow;
        $count=$req->count==null?1:$req->count;
        $isVip=$req->vip=="on"?true:false;
        $lastDate=$req->ago==null?"0000-00-00":(date("Y-m-d",strtotime("-".$req->ago." days")));
      
        if($isVip){
            $users=DB::table('ko_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ko_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('is_vip',true)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyKoreanUserData::where($row,'>=',$count) ->where('last_active','>=',$lastDate)->where('is_vip',true)->count();
        }else{
            $users=DB::table('ko_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ko_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyKoreanUserData::where($row,'>=',$count)->where('last_active','>=',$lastDate)->count();
        }
       
        return view('userlayouts.koreauser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
      
      
    }
    
    public function showPushNotification($id){
        $learner=learner::find($id);
        $phone=$learner->learner_phone;
        $koreaData=EasyKoreanUserData::where('phone',$phone)->first();
        $englishData=EasyEnglishUserData::where('phone',$phone)->first();
    
     

        return view('userlayouts.pushnotification',[
            'learner'=>$learner,
            'koreaData'=>$koreaData,
            'englishData'=>$englishData
        ]);
    }

    public function pushNotification(Request $req){
        $req->validate([
            'title'=>'required',
            'msg'=>'required'
        ]);

        $title=$req->title;
        $msg=$req->msg;
        $token=$req->app;
        
        FirebaseNotiPushController::pushNotificationToSingleUser($token,$title,$msg);

        return back()->with('msg','Cloud message sent.');
    }
    
    public function showVipsetting($id){
        $learner=learner::find($id);
        $phone=$learner->learner_phone;
        $koreaData=EasyKoreanUserData::where('phone',$phone)->first();
        $englishData=EasyEnglishUserData::where('phone',$phone)->first();
        
        $vipCoursesKorea=VipUser::where('phone',$phone)->where('major','korea')->get();
        $coursesKorea=array_column(json_decode($vipCoursesKorea),'course_id');
        
        $vipCoursesEnglish=VipUser::where('phone',$phone)->where('major','english')->get();
        $coursesEnglish=array_column(json_decode($vipCoursesEnglish),'course_id');
        
        $mainCourses=DB::table('courses')
        ->selectRaw("*")->get();

        return view('userlayouts.vipadding',[
            'learner'=>$learner,
            'koreaData'=>$koreaData,
            'englishData'=>$englishData,
            'coursesEnglish'=>$coursesEnglish,
            'coursesKorea'=>$coursesKorea,
            'mainCourses'=>$mainCourses
        ]);
    }
    
    public function addVip(Request $req, $id){
       

        $learner=learner::find($id);
        $phone=$learner->learner_phone;

        $mainCourses=course::get();
        
        
       // easy english courses
       if($req->major=="english"){

            //add blue mark

            if($req->vip_english=="on"){
                EasyEnglishUserData::where('phone',$phone)->update(['is_vip'=>1]); 
            }else{
                EasyEnglishUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }
       }

       foreach($mainCourses as $mainCourse){
            $id=$mainCourse->course_id;
            if($mainCourse->major==$req->major){
                if($req->$id=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => $mainCourse->course_id],
                    ['major' => "$mainCourse->major",'course'=>"$mainCourse->title"]
                );
        
                }else{
                    VipUser::where('phone',$phone)->where('course_id',$mainCourse->course_id)->where('major',$mainCourse->major)->delete();
                
                }
            }
            
        }
        
        
        //Easy Korean Courses
        
        if($req->major=="korea"){
            
            if($req->vip_korea=="on"){
                  EasyKoreanUserData::where('phone',$phone)->update(['is_vip'=>1]);
            }else{
                   EasyKoreanUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }


             //add specific course
            // foreach($mainCourses as $mainCourse){
            //     if($mainCourse->major=='korea'){
            //         $id=$mainCourse->course_id;
            //         if($req->$id=="on"){
            //             DB::table('VipUsers')
            //             ->updateOrInsert(
            //                 ['phone' => $phone, 'course_id' => $mainCourse->course_id],
            //                 ['major' => 'korea','course'=>"$mainCourse->title"]
            //             );
                    
            //         }else{
            //             VipUser::where('phone',$phone)->where('course_id',$mainCourse->course_id)->where('major','korea')->delete();
                    
            //         }
            //     }
            // }
          
        }
        
       return back()->with('msg','Successfully Updated.');
    }
}
