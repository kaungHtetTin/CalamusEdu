<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\learner;
use App\Models\EasyKoreanUserData;
use App\Models\EasyEnglishUserData;
use App\Models\EasyChineseUserData;
use App\Models\EasyJapaneseUserData;
use App\Models\EasyRussianUserData;
use Illuminate\Support\Facades\DB;

class ProjectOverviewController extends Controller
{
    public function index(){
        $learner_count=learner::get()->count();
        $korean_user_count=EasyKoreanUserData::get()->count();
        $english_user_count=EasyEnglishUserData::get()->count();
        $chinese_user_count=EasyChineseUserData::get()->count();
        $japanese_user_count=EasyJapaneseUserData::get()->count();
        $russian_user_count=EasyRussianUserData::get()->count();
        
        
        return view('layouts.overview',[
            'learner_count'=>$learner_count,
            'koeran_user_count'=>$korean_user_count,
            'english_user_count'=>$english_user_count,
            'chinese_user_count'=>$chinese_user_count,
            'japanese_user_count'=>$japanese_user_count,
            'russian_user_count'=>$russian_user_count
            ]);
    }
}
