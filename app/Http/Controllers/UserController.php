<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\learner;
use App\Models\EasyKoreanUserData;
use App\Models\EasyEnglishUserData;
use App\Models\VipUser;
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
        
        $mainCourses=DB::table('Courses')
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
        
        
       // easy english courses
       if($req->major=="english"){
            
            if($req->vip_english=="on"){
                EasyEnglishUserData::where('phone',$phone)->update(['is_vip'=>1]); 
            }else{
                EasyEnglishUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }
            
            if($req->basic_english=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '11'],
                    ['major' => 'english','course'=>'English Basic Course']
                );
               
            }else{
                VipUser::where('phone',$phone)->where('course_id','11')->where('major','english')->delete();
               
            }
            
            if($req->elementary_english=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '13'],
                    ['major' => 'english','course'=>'Elementary Course']
                );
               
            }else{
                VipUser::where('phone',$phone)->where('course_id','13')->where('major','english')->delete();
              
            }
            
       }
        
        
        //Easy Korean Courses
        
        if($req->major=="korea"){
            
            if($req->vip_korea=="on"){
                  EasyKoreanUserData::where('phone',$phone)->update(['is_vip'=>1]);
            }else{
                   EasyKoreanUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }
            
            if($req->basic_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => "1"],
                    ['major' => 'korea','course'=>'Basic Course']
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','1')->where('major','korea')->delete();
                
            }
            
            
            if($req->lv_one_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' =>'2'],
                    ['major' => 'korea','course'=>'Level One Course']
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','2')->where('major','korea')->delete();
            }
            
            
            if($req->lv_two_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '3'],
                    ['major' => 'korea','course'=>'Level Two Course']
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','3')->where('major','korea')->delete();
            }
            
            
            
            if($req->lv_three_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' =>'4'],
                    ['major' => 'korea','course' => "Level Three Course"]
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','4')->where('major','korea')->delete();
            }
            
            
            
            if($req->lv_four_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '7'],
                    ['major' => 'korea','course' => "Level Four Course"]
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','7')->where('major','korea')->delete();
            }
            
            
            if($req->vocab=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '15'],
                    ['major' => 'korea','course' => "Vocabulary Course"]
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','15')->where('major','korea')->delete();
            }
            
            
            if($req->kdrama=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '8'],
                    ['major' => 'korea','course' => "Lesson With K-Drama"]
                );
            }else{
                VipUser::where('phone',$phone)->where('course',"Lesson With K-Drama")->where('course_id','8')->where('major','korea')->delete();
            }
            
            if($req->kTranslation=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '10'],
                    ['major' => 'korea','course' => "Translation"]
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','10')->where('major','korea')->delete();
            }
            
            if($req->DramaLyrics=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '19'],
                    ['major' => 'korea','course' => "DramaLyrics"]
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','19')->where('major','korea')->delete();
            }
            
            if($req->KidSong=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '12'],
                    ['major' => 'korea', 'course' => "KidSong"]
                );
            }else{
                VipUser::where('phone',$phone)->where('course_id','12')->where('major','korea')->delete();
            }
            
            if($req->kGeneral=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course_id' => '8'],
                    ['major' => 'korea','course' => "General"]
                );
            }else{
                VipUser::where('phone',$phone)->where('course',"General")->where('major','korea')->delete();
            }
            
          
        }
        
        
       
      
        
       return back()->with('msg','Successfully Updated.');
    }
}
