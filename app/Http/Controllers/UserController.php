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
use App\Models\Partner;
use App\Models\PartnerEarning;
use App\Models\VipUser;
use App\Models\course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Hash;
use Validator;


class UserController extends Controller
{
    public function getUser(Request $req){
        $search = $req->get('search', '');
        
        $query = learner::orderBy('id','desc');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('learner_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('learner_phone', 'LIKE', '%' . $search . '%')
                  ->orWhere('learner_email', 'LIKE', '%' . $search . '%');
            });
        }
        
        $learners = $query->simplepaginate(20)->withQueryString();
        $learner_count = learner::get()->count();
        $korean_user_count = EasyKoreanUserData::get()->count();
        $english_user_count = EasyEnglishUserData::get()->count();
        $chinese_user_count = EasyChineseUserData::get()->count();
        $japanese_user_count = EasyJapaneseUserData::get()->count();
        $russian_user_count = EasyRussianUserData::get()->count();

        // User Activity Statistics
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        
        // Active users (last 7 days) - count distinct phones
        $active_users_7d = DB::table('ee_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $active_users_7d += DB::table('ko_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $active_users_7d += DB::table('cn_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $active_users_7d += DB::table('jp_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $active_users_7d += DB::table('ru_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 30 days)
        $active_users_30d = DB::table('ee_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $active_users_30d += DB::table('ko_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $active_users_30d += DB::table('cn_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $active_users_30d += DB::table('jp_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $active_users_30d += DB::table('ru_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 7 days)
        $new_users_7d = DB::table('ee_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $new_users_7d += DB::table('ko_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $new_users_7d += DB::table('cn_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $new_users_7d += DB::table('jp_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $new_users_7d += DB::table('ru_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 30 days)
        $new_users_30d = DB::table('ee_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $new_users_30d += DB::table('ko_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $new_users_30d += DB::table('cn_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $new_users_30d += DB::table('jp_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        $new_users_30d += DB::table('ru_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();

        return view('userlayouts.user',[
            'learners'=>$learners,
            'learner_count'=>$learner_count,
            'koeran_user_count'=>$korean_user_count,
            'english_user_count'=>$english_user_count,
            'chinese_user_count'=>$chinese_user_count,
            'japanese_user_count'=>$japanese_user_count,
            'russian_user_count'=>$russian_user_count,
            'search'=>$search,
            'active_users_7d'=>$active_users_7d,
            'active_users_30d'=>$active_users_30d,
            'new_users_7d'=>$new_users_7d,
            'new_users_30d'=>$new_users_30d,
        ]);
    }

    public function searchUser(Request $req){
        $msg = $req->msg;
        $learners = learner::where('learner_phone',$msg)
                    ->orWhere('learner_name', 'LIKE', '%' . $msg . '%')->get();
                    
        return view('userlayouts.searcheduser',[
            'learners'=>$learners,
        ]);
    }
    
    public function detail(Request $req){
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

        if(isset($req->api)){
            return "Password reset successfully";
        }

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
            $phone = str_replace([" ","+","*","#","-"], "", $phone);
            $learner=learner::where('learner_phone',$phone)->first();
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
            $response['japaneseData']=$japaneseData;
            $response['russianData']=$russianData;
            $response['chineseData']=$chineseData;
            
            $response['coursesEnglish']=$coursesEnglish;
            $response['coursesKorea']=$coursesKorea;
            $response['coursesJapanese']=$coursesJapanese;
            $response['coursesChinese']=$coursesChinese;
            $response['coursesRussian']=$coursesRussian;
            
            $response['mainCourses']=$mainCourses;
            return $response;
       }
    }
    
    public function addVip(Request $req, $id){
       

        $learner=learner::find($id);
        $phone=$learner->learner_phone;
        $mainCourses=course::get();
        
        //update paymant
        
        if($req->amount!=null || $req->amount!=0){
            
            if(isset($req->partner_code)){
                $partner_code = $req->partner_code;
                $partner = Partner::where('private_code',$partner_code)->first();
                if($partner){
                    $PartnerEarning = new PartnerEarning();
                    $PartnerEarning->partner_id = $partner->id;
                    $PartnerEarning->target_course_id  = null;
                    $PartnerEarning->target_package_id = null;
                    $PartnerEarning->learner_phone = $phone;
                    $PartnerEarning->price = $req->amount;
                    $PartnerEarning->commission_rate = $partner->commission_rate;
                    
                    $original_price = $req->amount / 0.9;  // 10 % discount to user_id 
                    $amount_received = ( $original_price * $partner->commission_rate ) /100;
                    
                    $PartnerEarning->amount_received = $amount_received;
                    $PartnerEarning->status = 'pending';
                    $PartnerEarning->save();
                    
                }else{
                    if(isset($req->api)){
                        return response(304).json("Wrong promotion Code! Activation fail");
                    }
                }
                
            }
            
            if(isset($req->api)){
                $screenshot="";
                $approve=0;
                $myPath="https://www.calamuseducation.com/financial/";
                $file=$req->file('myfile');
                if(!empty($req->myfile)){
                    $result=Storage::disk('calamusFinancial')->put('uploads',$file);
                    $screenshot=$myPath.$result;
                    
                }
                
            }else{
                $screenshot="";
                $approve=1;
            }
            
            $payment =new Payment();
            $payment->user_id=$phone;
            $payment->major=$req->major;
            $payment->amount=$req->amount;
            $payment->screenshot=$screenshot;
            $payment->approve=$approve;
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
        
        if(isset($req->api)){
            return "Activated";
        }
        
        
       return back()->with('msg','Successfully Updated.');
    }
    
    public function getEnroll(Request $req){
        
        $phone=$req->phone;
		$major=$req->major;
        
        $courses=DB::table('courses')
            ->selectRaw("
                courses.course_id,
                courses.lessons_count,
                background_color,
                title,
                description,
                cover_url
            ")
            ->where('major',$major)->get();
        
        $enrolls=DB::table('courses')
            ->selectRaw("
                courses.course_id,
                count(*) as learned,
                courses.lessons_count as total
            ")
            ->groupBy("courses.course_id")
            ->where("studies.learner_id",$phone)
            ->where("courses.major",$major)
            ->join("lessons_categories","lessons_categories.course_id","=","courses.course_id")
            ->join("lessons","lessons_categories.id","=","lessons.category_id")
            ->join("studies","lessons.id","=","studies.lesson_id")
            ->get();
            
        $data['enrolls']=$enrolls;
        $data['courses']=$courses;
        return $data;
        
    }
    
    public function getDiamondUsers(){
        
    }
    
    public function transferVipAccess(Request $req){
        $source_phone = $req->source;
        $target_phone = $req->target;
        $major = $req->major;
        
        $sourceUser = false;
        $targetUser = false;
        if($major=='korea'){
            $sourceUser=EasyKoreanUserData::where('phone',$source_phone)->first();
            $targetUser=EasyKoreanUserData::where('phone',$target_phone)->first();
        }
        
        if($major=='english'){
            $sourceUser=EasyEnglishUserData::where('phone',$source_phone)->first();
            $targetUser=EasyEnglishUserData::where('phone',$target_phone)->first();
        }
        
        if($major=='japanese'){
            $sourceUser=EasyJapaneseUserData::where('phone',$source_phone)->first();
            $targetUser=EasyJapaneseUserData::where('phone',$target_phone)->first();
        }
        
        if($major=='chinese'){
            $sourceUser=EasyChineseUserData::where('phone',$source_phone)->first();
            $targetUser=EasyChineseUserData::where('phone',$target_phone)->first();
        }
        
        if($major=='russian'){
            $sourceUser=EasyRussianUserData::where('phone',$source_phone)->first();
            $targetUser=EasyRussianUserData::where('phone',$target_phone)->first();
        }
        
        if(!$sourceUser){
            $response['status']="fail";
            $response['error'] = "The source user was not found!";
            return $response;
        }
        
        if(!$targetUser){
            $response['status']="fail";
            $response['error'] = "The target user was not found!";
            return $response;
        }
        
        $source_courses = VipUser::where('major',$major)->where('phone',$source_phone)->get();
        if(count($source_courses)==0){
            $response['status']="fail";
            $response['error'] = "The source is not a VIP account";
            return $response;
        }
        
        $target_courses = VipUser::where('major',$major)->where('phone',$target_phone)->get();
        if(count($target_courses)>0){
            $response['status']="fail";
            $response['error'] = "The target has been already a VIP account";
            return $response;
        }
        
        VipUser::where('phone',$source_phone)->where('major',$major)->update(['phone'=>$target_phone]);
        
        $targetUser->is_vip = $sourceUser->is_vip;
        $targetUser->gold_plan = $sourceUser->gold_plan;
        $targetUser->save();
        
        $sourceUser->is_vip = 0;
        $sourceUser->gold_plan = 0;
        $sourceUser->save();
        
        $response['status']="success";
        return $response;
        
    }
    
}
