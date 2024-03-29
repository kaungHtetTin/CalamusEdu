<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\learner;
use App\Models\EasyKoreanUserData;
use App\Models\EasyEnglishUserData;
use App\Models\EasyChineseUserData;
use App\Models\EasyJapaneseUserData;
use App\Models\EasyRussianUserData;
use App\Models\Payment;
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
        $chinese_user_count=EasyChineseUserData::get()->count();
        $japanese_user_count=EasyJapaneseUserData::get()->count();
        $russian_user_count=EasyRussianUserData::get()->count();

        return view('userlayouts.user',[
            'learners'=>$learners,
            'learner_count'=>$learner_count,
            'koeran_user_count'=>$korean_user_count,
            'english_user_count'=>$english_user_count,
            'chinese_user_count'=>$chinese_user_count,
            'japanese_user_count'=>$japanese_user_count,
            'russian_user_count'=>$russian_user_count,
        ]);
    }

    public function searchUser(Request $req){
        $phone=$req->phone;
        $message=$req->msg;
        $learner=learner::where('learner_phone',$phone)->first();
        $easykorean=EasyKoreanUserData::where('phone',$phone)->first();
        $easyenglish=EasyEnglishUserData::where('phone',$phone)->first();
        $easychinese=EasyChineseUserData::where('phone',$phone)->first();
        $easyjapanese=EasyJapaneseUserData::where('phone',$phone)->first();
        $easyrussian=EasyRussianUserData::where('phone',$phone)->first();
        
        return view('userlayouts.userdetail',[
            'learner'=>$learner,
            'easykorean'=>$easykorean,
            'easyenglish'=>$easyenglish,
            'easychinese'=>$easychinese,
            'easyjapanese'=>$easyjapanese,
            'easyrussian'=>$easyrussian,
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

    public function easyChineseUserDatas(){
        $users=DB::table('cn_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','cn_user_datas.phone','=','learners.learner_phone')
            ->orderBy('cn_user_datas.id','desc')
            ->simplepaginate(100);
        $counts=EasyChineseUserData::count();
        return view('userlayouts.chineseuser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
    }
    
    
    public function easyJapaneseUserDatas(){
        $users=DB::table('jp_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','jp_user_datas.phone','=','learners.learner_phone')
            ->orderBy('jp_user_datas.id','desc')
            ->simplepaginate(100);
        $counts=EasyJapaneseUserData::count();
        return view('userlayouts.japaneseuser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
    }
    
    public function easyRussianUserDatas(){
        $users=DB::table('ru_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ru_user_datas.phone','=','learners.learner_phone')
            ->orderBy('ru_user_datas.id','desc')
            ->simplepaginate(100);
        $counts=EasyRussianUserData::count();
        return view('userlayouts.russianuser',[
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
            ->join('VipUsers','ko_user_datas.phone','=','VipUsers.phone')
            ->where($row,'>=',$count)
            ->where('is_vip',true)
            ->where('last_active','>=',$lastDate)
            ->groupBy('ko_user_datas.phone')
            ->orderBy('date','desc')->simplepaginate(100)->withQueryString();
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
    
    public function filterChineseUser(Request $req){
        $row=$req->sqlrow;
        $count=$req->count==null?1:$req->count;
        $isVip=$req->vip=="on"?true:false;
        $lastDate=$req->ago==null?"0000-00-00":(date("Y-m-d",strtotime("-".$req->ago." days")));
      
        if($isVip){
            $users=DB::table('cn_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','cn_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('is_vip',true)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyChineseUserData::where($row,'>=',$count) ->where('last_active','>=',$lastDate)->where('is_vip',true)->count();
        }else{
            $users=DB::table('cn_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','cn_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyChineseUserData::where($row,'>=',$count)->where('last_active','>=',$lastDate)->count();
        }
       
        return view('userlayouts.chineseuser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
      
      
    }
    
    
    public function filterJapaneseUser(Request $req){
        $row=$req->sqlrow;
        $count=$req->count==null?1:$req->count;
        $isVip=$req->vip=="on"?true:false;
        $lastDate=$req->ago==null?"0000-00-00":(date("Y-m-d",strtotime("-".$req->ago." days")));
      
        if($isVip){
            $users=DB::table('jp_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','jp_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('is_vip',true)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyJapaneseUserData::where($row,'>=',$count) ->where('last_active','>=',$lastDate)->where('is_vip',true)->count();
        }else{
            $users=DB::table('jp_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','jp_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyJapaneseUserData::where($row,'>=',$count)->where('last_active','>=',$lastDate)->count();
        }
       
        return view('userlayouts.japaneseuser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
      
      
    }
    
    
    public function filterRussianUser(Request $req){
        $row=$req->sqlrow;
        $count=$req->count==null?1:$req->count;
        $isVip=$req->vip=="on"?true:false;
        $lastDate=$req->ago==null?"0000-00-00":(date("Y-m-d",strtotime("-".$req->ago." days")));
      
        if($isVip){
            $users=DB::table('ru_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ru_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('is_vip',true)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyRussianUserData::where($row,'>=',$count) ->where('last_active','>=',$lastDate)->where('is_vip',true)->count();
        }else{
            $users=DB::table('ru_user_datas')
            ->selectRaw("
                *
            ")
            ->join('learners','ru_user_datas.phone','=','learners.learner_phone')
            ->where($row,'>=',$count)
            ->where('last_active','>=',$lastDate)
            ->orderBy($row,'desc')->simplepaginate(100)->withQueryString();
            $counts=EasyRussianUserData::where($row,'>=',$count)->where('last_active','>=',$lastDate)->count();
        }
       
        return view('userlayouts.russianuser',[
            'users'=>$users,
            'counts'=>$counts
        ]);
      
      
    }
    
    public function showPushNotification($id){
        $learner=learner::find($id);
        $phone=$learner->learner_phone;
        $koreaData=EasyKoreanUserData::where('phone',$phone)->first();
        $englishData=EasyEnglishUserData::where('phone',$phone)->first();
        $chineseData=EasyChineseUserData::where('phone',$phone)->first();
        $japaneseData=EasyJapaneseUserData::where('phone',$phone)->first();
        $russianData=EasyRussianUserData::where('phone',$phone)->first();
    
        return view('userlayouts.pushnotification',[
            'learner'=>$learner,
            'koreaData'=>$koreaData,
            'englishData'=>$englishData,
            'chineseData'=>$chineseData,
            'japaneseData'=>$japaneseData,
            'russianData'=>$russianData,
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
    
    public function showVipsetting(Request $req,$id){
        
        if(isset($req->phone)){
            $phone=$req->phone;
            $learner=learner::where('learner_phone',$phone);
            $api=true;
        }else{
            $learner=learner::find($id);
            $phone=$learner->learner_phone;
            $api=false;
        }

        $koreaData=EasyKoreanUserData::where('phone',$phone)->first();
        $englishData=EasyEnglishUserData::where('phone',$phone)->first();
        $chineseData=EasyChineseUserData::where('phone',$phone)->first();
        $japaneseData=EasyJapaneseUserData::where('phone',$phone)->first();
        $russianData=EasyRussianUserData::where('phone',$phone)->first();
        
        $vipCoursesKorea=VipUser::where('phone',$phone)->where('major','korea')->get();
        $coursesKorea=array_column(json_decode($vipCoursesKorea),'course_id');
        
        $vipCoursesEnglish=VipUser::where('phone',$phone)->where('major','english')->get();
        $coursesEnglish=array_column(json_decode($vipCoursesEnglish),'course_id');
        
        $vipCoursesChinese=VipUser::where('phone',$phone)->where('major','chinese')->get();
        $coursesChinese=array_column(json_decode($vipCoursesChinese),'course_id');
        
        $vipCoursesJapanese=VipUser::where('phone',$phone)->where('major','japanese')->get();
        $coursesJapanese=array_column(json_decode($vipCoursesJapanese),'course_id');
        
        $vipCoursesRussian=VipUser::where('phone',$phone)->where('major','russian')->get();
        $coursesRussian=array_column(json_decode($vipCoursesRussian),'course_id');
        
        $mainCourses=DB::table('courses')
        ->selectRaw("*")->get();

       if(!$api){
            return view('userlayouts.vipadding',[
                'learner'=>$learner,
                'koreaData'=>$koreaData,
                'englishData'=>$englishData,
                'chineseData'=>$chineseData,
                'JapaneseData'=>$japaneseData,
                'russianData'=>$russianData,
                'coursesEnglish'=>$coursesEnglish,
                'coursesKorea'=>$coursesKorea,
                'coursesChinese'=>$coursesChinese,
                'coursesJapanese'=>$coursesJapanese,
                'coursesRussian'=>$coursesRussian,
                'mainCourses'=>$mainCourses
            ]);
       }else{
            $response['learner']=$learner;
            $response['koreaData']=$koreaData;
            $response['englishData']=$englishData;
            $response['coursesEnglish']=$coursesEnglish;
            $response['coursesKorea']=$coursesKorea;
            $response['mainCourses']=$mainCourses;
            return $response;
       }
    }
    
    public function addVip(Request $req, $id){
       

        $learner=learner::find($id);
        $phone=$learner->learner_phone;
        $mainCourses=course::get();
        
        //update paymant
        
        if($req->amount!=null){
            $payment =new Payment();
            $payment->user_id=$phone;
            $payment->major=$req->major;
            $payment->amount=$req->amount;
            $payment->save();
            
        }
        
       // easy english courses
       if($req->major=="english"){

            //add blue mark

            if($req->vip_english=="on"){
                EasyEnglishUserData::where('phone',$phone)->update(['is_vip'=>1]); 
            }else{
                EasyEnglishUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }
            
            // add gold plan
                
            if($req->gold_plan=="on"){
                  EasyEnglishUserData::where('phone',$phone)->update(['gold_plan'=>1]);
            }else{
                  EasyEnglishUserData::where('phone',$phone)->update(['gold_plan'=>0]);
            }
       }

        //Easy Korean Courses
        if($req->major=="korea"){

               //add blue mark
            
            if($req->vip_korea=="on"){
                  EasyKoreanUserData::where('phone',$phone)->update(['is_vip'=>1]);
            }else{
                  EasyKoreanUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }
            
            // add gold plan
                
            if($req->gold_plan=="on"){
                  EasyKoreanUserData::where('phone',$phone)->update(['gold_plan'=>1]);
            }else{
                  EasyKoreanUserData::where('phone',$phone)->update(['gold_plan'=>0]);
            }
          
        }
        
        //Easy Chinese Courses
        if($req->major=="chinese"){

               //add blue mark
            
            if($req->vip_chinese=="on"){
                  EasyChineseUserData::where('phone',$phone)->update(['is_vip'=>1]);
            }else{
                   EasyChineseUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }
          
        }
        
        if($req->major=="japanese"){

               //add blue mark
            
            if($req->vip_japanese=="on"){
                  EasyJapaneseUserData::where('phone',$phone)->update(['is_vip'=>1]);
            }else{
                   EasyJapaneseUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }
          
        }
        
        if($req->major=="russian"){

               //add blue mark
            
            if($req->vip_russian=="on"){
                  EasyRussianUserData::where('phone',$phone)->update(['is_vip'=>1]);
            }else{
                   EasyRussianUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }
          
        }


        // add specific course
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
        
       return back()->with('msg','Successfully Updated.');
    }
}
