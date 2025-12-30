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
    
    public function easyEnglishUserDatas(Request $req){
        $search = $req->get('search', '');
        
        $query = DB::table('ee_user_datas')
            ->selectRaw("*")
            ->join('learners','ee_user_datas.phone','=','learners.learner_phone');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('learners.learner_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_phone', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_email', 'LIKE', '%' . $search . '%');
            });
        }
        
        $users = $query->orderBy('ee_user_datas.id','desc')
            ->simplepaginate(100)
            ->withQueryString();
        
        $counts = EasyEnglishUserData::count();
        
        // VIP user count
        $vip_counts = EasyEnglishUserData::where('is_vip', 1)->count();
        
        // User Activity Statistics
        $todayStart = date('Y-m-d 00:00:00');
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        
        // Active users today
        $active_users_today = DB::table('ee_user_datas')
            ->where('last_active', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 7 days)
        $active_users_7d = DB::table('ee_user_datas')
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
        
        // New users today
        $new_users_today = DB::table('ee_user_datas')
            ->where('first_join', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 7 days)
        $new_users_7d = DB::table('ee_user_datas')
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
      
        $languageConfig = [
            'name' => 'English',
            'primaryColor' => '#2196F3',
            'secondaryColor' => '#1976D2'
        ];
      
        return view('userlayouts.languageuser',[
            'users'=>$users,
            'counts'=>$counts,
            'vip_counts'=>$vip_counts,
            'languageConfig'=>$languageConfig,
            'search'=>$search,
            'active_users_today'=>$active_users_today,
            'active_users_7d'=>$active_users_7d,
            'active_users_30d'=>$active_users_30d,
            'new_users_today'=>$new_users_today,
            'new_users_7d'=>$new_users_7d,
            'new_users_30d'=>$new_users_30d
        ]);
    }


    public function easyKoreanUserDatas(Request $req){
        $search = $req->get('search', '');
        
        $query = DB::table('ko_user_datas')
            ->selectRaw("*")
            ->join('learners','ko_user_datas.phone','=','learners.learner_phone');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('learners.learner_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_phone', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_email', 'LIKE', '%' . $search . '%');
            });
        }
        
        $users = $query->orderBy('ko_user_datas.id','desc')
            ->simplepaginate(100)
            ->withQueryString();
        
        $counts = EasyKoreanUserData::count();
        
        // VIP user count
        $vip_counts = EasyKoreanUserData::where('is_vip', 1)->count();
        
        // User Activity Statistics
        $todayStart = date('Y-m-d 00:00:00');
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        
        // Active users today
        $active_users_today = DB::table('ko_user_datas')
            ->where('last_active', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 7 days)
        $active_users_7d = DB::table('ko_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 30 days)
        $active_users_30d = DB::table('ko_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users today
        $new_users_today = DB::table('ko_user_datas')
            ->where('first_join', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 7 days)
        $new_users_7d = DB::table('ko_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 30 days)
        $new_users_30d = DB::table('ko_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        $languageConfig = [
            'name' => 'Korean',
            'primaryColor' => '#FF9800',
            'secondaryColor' => '#F57C00'
        ];
        
        return view('userlayouts.languageuser',[
            'users'=>$users,
            'counts'=>$counts,
            'vip_counts'=>$vip_counts,
            'languageConfig'=>$languageConfig,
            'search'=>$search,
            'active_users_today'=>$active_users_today,
            'active_users_7d'=>$active_users_7d,
            'active_users_30d'=>$active_users_30d,
            'new_users_today'=>$new_users_today,
            'new_users_7d'=>$new_users_7d,
            'new_users_30d'=>$new_users_30d
        ]);
    }

    public function easyChineseUserDatas(Request $req){
        $search = $req->get('search', '');
        
        $query = DB::table('cn_user_datas')
            ->selectRaw("*")
            ->join('learners','cn_user_datas.phone','=','learners.learner_phone');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('learners.learner_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_phone', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_email', 'LIKE', '%' . $search . '%');
            });
        }
        
        $users = $query->orderBy('cn_user_datas.id','desc')
            ->simplepaginate(100)
            ->withQueryString();
        
        $counts = EasyChineseUserData::count();
        
        // VIP user count
        $vip_counts = EasyChineseUserData::where('is_vip', 1)->count();
        
        // User Activity Statistics
        $todayStart = date('Y-m-d 00:00:00');
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        
        // Active users today
        $active_users_today = DB::table('cn_user_datas')
            ->where('last_active', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 7 days)
        $active_users_7d = DB::table('cn_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 30 days)
        $active_users_30d = DB::table('cn_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users today
        $new_users_today = DB::table('cn_user_datas')
            ->where('first_join', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 7 days)
        $new_users_7d = DB::table('cn_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 30 days)
        $new_users_30d = DB::table('cn_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        $languageConfig = [
            'name' => 'Chinese',
            'primaryColor' => '#F44336',
            'secondaryColor' => '#D32F2F'
        ];
        
        return view('userlayouts.languageuser',[
            'users'=>$users,
            'counts'=>$counts,
            'vip_counts'=>$vip_counts,
            'languageConfig'=>$languageConfig,
            'search'=>$search,
            'active_users_today'=>$active_users_today,
            'active_users_7d'=>$active_users_7d,
            'active_users_30d'=>$active_users_30d,
            'new_users_today'=>$new_users_today,
            'new_users_7d'=>$new_users_7d,
            'new_users_30d'=>$new_users_30d
        ]);
    }
    
    
    public function easyJapaneseUserDatas(Request $req){
        $search = $req->get('search', '');
        
        $query = DB::table('jp_user_datas')
            ->selectRaw("*")
            ->join('learners','jp_user_datas.phone','=','learners.learner_phone');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('learners.learner_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_phone', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_email', 'LIKE', '%' . $search . '%');
            });
        }
        
        $users = $query->orderBy('jp_user_datas.id','desc')
            ->simplepaginate(100)
            ->withQueryString();
        
        $counts = EasyJapaneseUserData::count();
        
        // VIP user count
        $vip_counts = EasyJapaneseUserData::where('is_vip', 1)->count();
        
        // User Activity Statistics
        $todayStart = date('Y-m-d 00:00:00');
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        
        // Active users today
        $active_users_today = DB::table('jp_user_datas')
            ->where('last_active', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 7 days)
        $active_users_7d = DB::table('jp_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 30 days)
        $active_users_30d = DB::table('jp_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users today
        $new_users_today = DB::table('jp_user_datas')
            ->where('first_join', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 7 days)
        $new_users_7d = DB::table('jp_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 30 days)
        $new_users_30d = DB::table('jp_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        $languageConfig = [
            'name' => 'Japanese',
            'primaryColor' => '#9C27B0',
            'secondaryColor' => '#7B1FA2'
        ];
        
        return view('userlayouts.languageuser',[
            'users'=>$users,
            'counts'=>$counts,
            'vip_counts'=>$vip_counts,
            'languageConfig'=>$languageConfig,
            'search'=>$search,
            'active_users_today'=>$active_users_today,
            'active_users_7d'=>$active_users_7d,
            'active_users_30d'=>$active_users_30d,
            'new_users_today'=>$new_users_today,
            'new_users_7d'=>$new_users_7d,
            'new_users_30d'=>$new_users_30d
        ]);
    }
    
    public function easyRussianUserDatas(Request $req){
        $search = $req->get('search', '');
        
        $query = DB::table('ru_user_datas')
            ->selectRaw("*")
            ->join('learners','ru_user_datas.phone','=','learners.learner_phone');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('learners.learner_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_phone', 'LIKE', '%' . $search . '%')
                  ->orWhere('learners.learner_email', 'LIKE', '%' . $search . '%');
            });
        }
        
        $users = $query->orderBy('ru_user_datas.id','desc')
            ->simplepaginate(100)
            ->withQueryString();
        
        $counts = EasyRussianUserData::count();
        
        // VIP user count
        $vip_counts = EasyRussianUserData::where('is_vip', 1)->count();
        
        // User Activity Statistics
        $todayStart = date('Y-m-d 00:00:00');
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        
        // Active users today
        $active_users_today = DB::table('ru_user_datas')
            ->where('last_active', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 7 days)
        $active_users_7d = DB::table('ru_user_datas')
            ->where('last_active', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // Active users (last 30 days)
        $active_users_30d = DB::table('ru_user_datas')
            ->where('last_active', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users today
        $new_users_today = DB::table('ru_user_datas')
            ->where('first_join', '>=', $todayStart)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 7 days)
        $new_users_7d = DB::table('ru_user_datas')
            ->where('first_join', '>=', $sevenDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        // New users (last 30 days)
        $new_users_30d = DB::table('ru_user_datas')
            ->where('first_join', '>=', $thirtyDaysAgo)
            ->select('phone')
            ->distinct()
            ->count();
        
        $languageConfig = [
            'name' => 'Russian',
            'primaryColor' => '#4CAF50',
            'secondaryColor' => '#388E3C'
        ];
        
        return view('userlayouts.languageuser',[
            'users'=>$users,
            'counts'=>$counts,
            'vip_counts'=>$vip_counts,
            'languageConfig'=>$languageConfig,
            'search'=>$search,
            'active_users_today'=>$active_users_today,
            'active_users_7d'=>$active_users_7d,
            'active_users_30d'=>$active_users_30d,
            'new_users_today'=>$new_users_today,
            'new_users_7d'=>$new_users_7d,
            'new_users_30d'=>$new_users_30d
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
    
    public function showUserPerformance($phone, $language){
        $learner = learner::where('learner_phone', $phone)->first();
        
        if (!$learner) {
            abort(404, 'User not found');
        }
        
        // Map language names to models, table names, and course major values
        $languageMap = [
            'english' => [
                'model' => EasyEnglishUserData::class, 
                'table' => 'ee_user_datas', 
                'name' => 'English',
                'major' => 'english'
            ],
            'korean' => [
                'model' => EasyKoreanUserData::class, 
                'table' => 'ko_user_datas', 
                'name' => 'Korean',
                'major' => 'korea'
            ],
            'chinese' => [
                'model' => EasyChineseUserData::class, 
                'table' => 'cn_user_datas', 
                'name' => 'Chinese',
                'major' => 'chinese'
            ],
            'japanese' => [
                'model' => EasyJapaneseUserData::class, 
                'table' => 'jp_user_datas', 
                'name' => 'Japanese',
                'major' => 'japanese'
            ],
            'russian' => [
                'model' => EasyRussianUserData::class, 
                'table' => 'ru_user_datas', 
                'name' => 'Russian',
                'major' => 'russian'
            ],
        ];
        
        $lang = $languageMap[strtolower($language)] ?? null;
        
        if (!$lang) {
            abort(404, 'Invalid language');
        }
        
        $userData = $lang['model']::where('phone', $phone)->first();
        
        if (!$userData) {
            return redirect()->route('detail', ['phone' => $phone])->with('error', 'No data found for this language.');
        }
        
        // Get user ID - try both user_id and id for enrollment, use id for studies
        $userIdForEnroll = $learner->user_id ?? $learner->id;
        $learnerIdForStudies = $learner->id; // studies table uses learner_id which should be learners.id
        
        // Get all courses for this language
        $courses = course::where('major', $lang['major'])
            ->orderBy('sorting', 'asc')
            ->get();
        
        // Get course progress data
        $courseProgress = [];
        
        foreach ($courses as $course) {
            // Check if user is enrolled in this course (try both user_id and id)
            $enrollment = DB::table('course_enroll')
                ->where(function($query) use ($userIdForEnroll, $learner) {
                    $query->where('user_id', $userIdForEnroll)
                          ->orWhere('user_id', $learner->id);
                })
                ->where('course_id', $course->course_id)
                ->first();
            
            // Get all lessons in this course (via categories)
            $categoryIds = DB::table('lessons_categories')
                ->where('course_id', $course->course_id)
                ->pluck('id')
                ->toArray();
            
            $totalLessons = DB::table('lessons')
                ->whereIn('category_id', $categoryIds)
                ->count();
            
            // Get completed lessons (from studies table - uses learner_id)
            $completedLessons = 0;
            if ($totalLessons > 0 && !empty($categoryIds)) {
                $lessonIds = DB::table('lessons')
                    ->whereIn('category_id', $categoryIds)
                    ->pluck('id')
                    ->toArray();
                
                if (!empty($lessonIds)) {
                    $completedLessons = DB::table('studies')
                        ->where('learner_id', $learnerIdForStudies)
                        ->whereIn('lesson_id', $lessonIds)
                        ->distinct('lesson_id')
                        ->count('lesson_id');
                }
            }
            
            // Calculate progress percentage
            $progressPercentage = $totalLessons > 0 
                ? round(($completedLessons / $totalLessons) * 100, 1) 
                : 0;
            
            // Use enrollment progress if available, otherwise use calculated progress
            $displayProgress = $enrollment ? $enrollment->progress : $progressPercentage;
            
            $courseProgress[] = [
                'course' => $course,
                'enrolled' => $enrollment ? true : false,
                'enrollment' => $enrollment,
                'totalLessons' => $totalLessons,
                'completedLessons' => $completedLessons,
                'progress' => $displayProgress,
                'calculatedProgress' => $progressPercentage
            ];
        }
        
        return view('userlayouts.userperformance', [
            'learner' => $learner,
            'userData' => $userData,
            'language' => $lang['name'],
            'languageCode' => strtolower($language),
            'courseProgress' => $courseProgress
        ]);
    }
    
    public function showLanguageVipManagement($phone, $language){
        $learner = learner::where('learner_phone', $phone)->first();
        
        if (!$learner) {
            abort(404, 'User not found');
        }
        
        // Map language names to models, table names, and course major values
        $languageMap = [
            'english' => [
                'model' => EasyEnglishUserData::class, 
                'table' => 'ee_user_datas', 
                'name' => 'English',
                'major' => 'english',
                'vipField' => 'vip_english'
            ],
            'korean' => [
                'model' => EasyKoreanUserData::class, 
                'table' => 'ko_user_datas', 
                'name' => 'Korean',
                'major' => 'korea',
                'vipField' => 'vip_korea'
            ],
            'chinese' => [
                'model' => EasyChineseUserData::class, 
                'table' => 'cn_user_datas', 
                'name' => 'Chinese',
                'major' => 'chinese',
                'vipField' => 'vip_chinese'
            ],
            'japanese' => [
                'model' => EasyJapaneseUserData::class, 
                'table' => 'jp_user_datas', 
                'name' => 'Japanese',
                'major' => 'japanese',
                'vipField' => 'vip_japanese'
            ],
            'russian' => [
                'model' => EasyRussianUserData::class, 
                'table' => 'ru_user_datas', 
                'name' => 'Russian',
                'major' => 'russian',
                'vipField' => 'vip_russian'
            ],
        ];
        
        $lang = $languageMap[strtolower($language)] ?? null;
        
        if (!$lang) {
            abort(404, 'Invalid language');
        }
        
        $userData = $lang['model']::where('phone', $phone)->first();
        
        if (!$userData) {
            return redirect()->route('detail', ['phone' => $phone])->with('error', 'No data found for this language.');
        }
        
        // Get all courses for this language
        $courses = course::where('major', $lang['major'])
            ->orderBy('sorting', 'asc')
            ->get();
        
        // Get VIP courses for this user and language
        $vipCourses = VipUser::where('phone', $phone)
            ->where('major', $lang['major'])
            ->pluck('course_id')
            ->toArray();
        
        return view('userlayouts.languagevipmanagement', [
            'learner' => $learner,
            'userData' => $userData,
            'language' => $lang['name'],
            'languageCode' => strtolower($language),
            'major' => $lang['major'],
            'vipField' => $lang['vipField'],
            'courses' => $courses,
            'vipCourses' => $vipCourses
        ]);
    }
    
    public function updateLanguageVip(Request $req, $phone, $language){
        $learner = learner::where('learner_phone', $phone)->first();
        
        if (!$learner) {
            return back()->with('error', 'User not found');
        }
        
        // Map language names to models and major values
        $languageMap = [
            'english' => [
                'model' => EasyEnglishUserData::class, 
                'name' => 'English',
                'major' => 'english',
                'vipField' => 'vip_english'
            ],
            'korean' => [
                'model' => EasyKoreanUserData::class, 
                'name' => 'Korean',
                'major' => 'korea',
                'vipField' => 'vip_korea'
            ],
            'chinese' => [
                'model' => EasyChineseUserData::class, 
                'name' => 'Chinese',
                'major' => 'chinese',
                'vipField' => 'vip_chinese'
            ],
            'japanese' => [
                'model' => EasyJapaneseUserData::class, 
                'name' => 'Japanese',
                'major' => 'japanese',
                'vipField' => 'vip_japanese'
            ],
            'russian' => [
                'model' => EasyRussianUserData::class, 
                'name' => 'Russian',
                'major' => 'russian',
                'vipField' => 'vip_russian'
            ],
        ];
        
        $lang = $languageMap[strtolower($language)] ?? null;
        
        if (!$lang) {
            return back()->with('error', 'Invalid language');
        }
        
        // Update VIP status
        $isVip = $req->has($lang['vipField']) ? 1 : 0;
        $lang['model']::where('phone', $phone)->update(['is_vip' => $isVip]);
        
        // Update Gold Plan (if applicable)
        if ($req->has('gold_plan')) {
            $lang['model']::where('phone', $phone)->update(['gold_plan' => 1]);
        } else {
            // Only update if the model has gold_plan field (check if it exists)
            try {
                $lang['model']::where('phone', $phone)->update(['gold_plan' => 0]);
            } catch (\Exception $e) {
                // Field might not exist for some languages, ignore
            }
        }
        
        // Get all courses for this language
        $courses = course::where('major', $lang['major'])->get();
        
        // Update VIP courses
        foreach ($courses as $course) {
            $courseId = $course->course_id;
            if ($req->has($courseId)) {
                // Add/Update VIP course
                DB::table('VipUsers')->updateOrInsert(
                    [
                        'phone' => $phone,
                        'course_id' => $courseId,
                        'major' => $lang['major']
                    ],
                    [
                        'course' => $course->title,
                        'date' => date('Y-m-d'),
                        'deleted_account' => 0
                    ]
                );
            } else {
                // Remove VIP course
                DB::table('VipUsers')
                    ->where('phone', $phone)
                    ->where('course_id', $courseId)
                    ->where('major', $lang['major'])
                    ->delete();
            }
        }
        
        // Handle payment if amount is provided
        if ($req->amount && $req->amount > 0) {
            $payment = new Payment();
            $payment->user_id = $phone;
            $payment->major = $lang['major'];
            $payment->amount = $req->amount;
            $payment->screenshot = '';
            $payment->approve = 1; // Auto-approve for admin
            $payment->save();
        }
        
        return redirect()->route('languageVipManagement', ['phone' => $phone, 'language' => $language])
            ->with('success', 'VIP access updated successfully for ' . $lang['name']);
    }
    
}
