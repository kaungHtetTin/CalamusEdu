<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\learner;
use App\Models\EasyKoreanUserData;
use App\Models\EasyEnglishUserData;
use App\Models\EasyChineseUserData;
use App\Models\EasyJapaneseUserData;
use App\Models\EasyRussianUserData;
use App\Models\course;
use App\Models\lesson;
use App\Models\post;
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
        
        // Overview statistics
        $course_count = course::get()->count();
        $lesson_count = lesson::get()->count();
        $post_count = post::get()->count();
        
        // Get chart data for last 30 days
        $days = 30;
        $chartData = $this->getUserActivityChartData($days);
        
        return view('layouts.overview',[
            'learner_count' => $learner_count,
            'korean_user_count' => $korean_user_count,
            'english_user_count' => $english_user_count,
            'chinese_user_count' => $chinese_user_count,
            'japanese_user_count' => $japanese_user_count,
            'russian_user_count' => $russian_user_count,
            'course_count' => $course_count,
            'lesson_count' => $lesson_count,
            'post_count' => $post_count,
            'chart_labels' => $chartData['labels'],
            'new_users_data' => $chartData['new_users'],
            'active_users_data' => $chartData['active_users'],
        ]);
    }
    
    private function getUserActivityChartData($days = 30) {
        // Generate date labels for the last N days
        $labels = [];
        $newUsersData = [];
        $activeUsersData = [];
        
        $languageTables = [
            'ee_user_datas' => 'english',
            'ko_user_datas' => 'korean',
            'cn_user_datas' => 'chinese',
            'jp_user_datas' => 'japanese',
            'ru_user_datas' => 'russian'
        ];
        
        // Initialize arrays for each day
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('M j', strtotime("-$i days"));
            $newUsersData[$date] = 0;
            $activeUsersData[$date] = 0;
        }
        
        // Get new users by first_join date
        $startDate = date('Y-m-d 00:00:00', strtotime("-$days days"));
        foreach ($languageTables as $table => $lang) {
            $newUsers = DB::table($table)
                ->select(DB::raw('DATE(first_join) as date'), DB::raw('COUNT(DISTINCT phone) as count'))
                ->where('first_join', '>=', $startDate)
                ->where('first_join', '!=', '0000-00-00 00:00:00')
                ->whereNotNull('first_join')
                ->groupBy(DB::raw('DATE(first_join)'))
                ->get();
            
            foreach ($newUsers as $user) {
                if (isset($newUsersData[$user->date])) {
                    $newUsersData[$user->date] += $user->count;
                }
            }
        }
        
        // Get active users by last_active date
        foreach ($languageTables as $table => $lang) {
            $activeUsers = DB::table($table)
                ->select(DB::raw('DATE(last_active) as date'), DB::raw('COUNT(DISTINCT phone) as count'))
                ->where('last_active', '>=', $startDate)
                ->whereNotNull('last_active')
                ->groupBy(DB::raw('DATE(last_active)'))
                ->get();
            
            foreach ($activeUsers as $user) {
                if (isset($activeUsersData[$user->date])) {
                    $activeUsersData[$user->date] += $user->count;
                }
            }
        }
        
        // Convert to arrays in the correct order
        $newUsersArray = [];
        $activeUsersArray = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $newUsersArray[] = $newUsersData[$date];
            $activeUsersArray[] = $activeUsersData[$date];
        }
        
        return [
            'labels' => $labels,
            'new_users' => $newUsersArray,
            'active_users' => $activeUsersArray,
        ];
    }
}
