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
        
        $vipCourses=VipUser::where('phone',$phone)->get();
        $courses=array_column(json_decode($vipCourses),'course');
        
        return view('userlayouts.vipadding',[
            'learner'=>$learner,
            'koreaData'=>$koreaData,
            'englishData'=>$englishData,
            'courses'=>$courses
        ]);
    }
    
    public function addVip(Request $req, $id){
       

        $learner=learner::find($id);
        $phone=$learner->learner_phone;
        
        
       // easy english courses
       if($req->major=="english"){
            if($req->basic_english=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course' => 'Basic English Course'],
                    ['major' => 'english']
                );
                $english_basic=true;
            }else{
                VipUser::where('phone',$phone)->where('course','Basic English Course')->delete();
                $english_basic=false;
            }
           
           if($req->voa=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course' => "Let's Learn English (VOA)"],
                    ['major' => 'english']
                );
                $voa=true;
            }else{
                VipUser::where('phone',$phone)->where('course',"Let's Learn English (VOA)")->delete();
                $voa=false;
            }
            
            
            if($req->voa==null and $req->voa==null ){
                EasyEnglishUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }else{
                EasyEnglishUserData::where('phone',$phone)->update(['is_vip'=>1]);
            }
       }
        
        
        //Easy Korean Courses
        
        if($req->major=="korea"){
            if($req->basic_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course' => "Basic course"],
                    ['major' => 'korea']
                );
            }else{
                VipUser::where('phone',$phone)->where('course',"Basic course")->delete();
                
            }
            
            
            if($req->lv_one_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course' => "Level One Course"],
                    ['major' => 'korea']
                );
            }else{
                VipUser::where('phone',$phone)->where('course',"Level One Course")->delete();
            }
            
            
            if($req->lv_two_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course' => "Level Two Course"],
                    ['major' => 'korea']
                );
            }else{
                VipUser::where('phone',$phone)->where('course',"Level Two Course")->delete();
            }
            
            
            
            if($req->lv_three_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course' => "Level Three Course"],
                    ['major' => 'korea']
                );
            }else{
                VipUser::where('phone',$phone)->where('course',"Level Three Course")->delete();
            }
            
            
            
            if($req->lv_four_korea=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course' => "Level Four Course"],
                    ['major' => 'korea']
                );
            }else{
                VipUser::where('phone',$phone)->where('course',"Level Four Course")->delete();
            }
            
            
            if($req->kdrama=="on"){
                DB::table('VipUsers')
                ->updateOrInsert(
                    ['phone' => $phone, 'course' => "Lesson With K-Drama"],
                    ['major' => 'korea']
                );
            }else{
                VipUser::where('phone',$phone)->where('course',"Lesson With K-Drama")->delete();
            }
            
            $koreaValidator=Validator::make($req->all(),[
                'basic_korea'=>'required',
                'lv_one_korea'=>'required',
                'lv_two_korea'=>'required',
                'lv_three_korea'=>'required', 
                'lv_four_korea'=>'required',
                'kdrama'=>'required',
            ]);
            
            if($req->basic_korea==null and $req->lv_one_korea==null and $req->lv_two_korea==null and $req->lv_three_korea==null and $req->lv_four_korea==null and $req->lv_kdrama_korea==null ){
                EasyKoreanUserData::where('phone',$phone)->update(['is_vip'=>0]);
            }else{
                EasyKoreanUserData::where('phone',$phone)->update(['is_vip'=>1]);
            }
        }
        
        
       
      
        
       return back()->with('msg','Successfully Updated.');
    }
}
