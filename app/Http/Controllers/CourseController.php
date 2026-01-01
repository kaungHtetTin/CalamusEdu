<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\course;
use App\Models\VipUser;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function showCoursesMain(){
        // Course Statistics
        $total_courses = course::count();
        
        // Courses by language
        $english_courses = course::where('major', 'english')->count();
        $korean_courses = course::where('major', 'korea')->count();
        $chinese_courses = course::where('major', 'chinese')->count();
        $japanese_courses = course::where('major', 'japanese')->count();
        $russian_courses = course::where('major', 'russian')->count();
        
        // VIP vs Regular courses
        $vip_courses = course::where('is_vip', 1)->count();
        $regular_courses = course::where('is_vip', 0)->count();
        
        // Total enrollments from VipUsers table (excluding deleted accounts)
        $total_enrollments = VipUser::where('deleted_account', 0)->count();
        
        // Average rating
        $avg_rating = course::avg('rating');
        $avg_rating = $avg_rating ? round($avg_rating, 2) : 0;
        
        // Total lessons across all courses
        $total_lessons_in_courses = course::sum('lessons_count');
        
        // Enrollments by language from VipUsers table
        $english_enrollments = VipUser::where('major', 'english')->where('deleted_account', 0)->count();
        $korean_enrollments = VipUser::where('major', 'korea')->where('deleted_account', 0)->count();
        $chinese_enrollments = VipUser::where('major', 'chinese')->where('deleted_account', 0)->count();
        $japanese_enrollments = VipUser::where('major', 'japanese')->where('deleted_account', 0)->count();
        $russian_enrollments = VipUser::where('major', 'russian')->where('deleted_account', 0)->count();
        
        // Average rating by language
        $english_avg_rating = course::where('major', 'english')->avg('rating');
        $korean_avg_rating = course::where('major', 'korea')->avg('rating');
        $chinese_avg_rating = course::where('major', 'chinese')->avg('rating');
        $japanese_avg_rating = course::where('major', 'japanese')->avg('rating');
        $russian_avg_rating = course::where('major', 'russian')->avg('rating');
        
        return view('courses.coursesmain', [
            'total_courses' => $total_courses,
            'english_courses' => $english_courses,
            'korean_courses' => $korean_courses,
            'chinese_courses' => $chinese_courses,
            'japanese_courses' => $japanese_courses,
            'russian_courses' => $russian_courses,
            'vip_courses' => $vip_courses,
            'regular_courses' => $regular_courses,
            'total_enrollments' => $total_enrollments,
            'avg_rating' => $avg_rating,
            'total_lessons_in_courses' => $total_lessons_in_courses,
            'english_enrollments' => $english_enrollments,
            'korean_enrollments' => $korean_enrollments,
            'chinese_enrollments' => $chinese_enrollments,
            'japanese_enrollments' => $japanese_enrollments,
            'russian_enrollments' => $russian_enrollments,
            'english_avg_rating' => $english_avg_rating ? round($english_avg_rating, 2) : 0,
            'korean_avg_rating' => $korean_avg_rating ? round($korean_avg_rating, 2) : 0,
            'chinese_avg_rating' => $chinese_avg_rating ? round($chinese_avg_rating, 2) : 0,
            'japanese_avg_rating' => $japanese_avg_rating ? round($japanese_avg_rating, 2) : 0,
            'russian_avg_rating' => $russian_avg_rating ? round($russian_avg_rating, 2) : 0,
        ]);
    }

    public function showCoursesByLanguage($language){
        // Validate language parameter
        $validLanguages = ['english', 'korea', 'chinese', 'japanese', 'russian'];
        if (!in_array($language, $validLanguages)) {
            abort(404, 'Invalid language');
        }

        $major = $language;

        // Fetch courses for the language
        $courses = course::where('major', $major)
            ->orderBy('sorting', 'asc')
            ->orderBy('course_id', 'asc')
            ->get();

        // Get enrollment counts for each course from VipUsers
        foreach($courses as $course) {
            $course->enrollment_count = VipUser::where('course_id', $course->course_id)
                ->where('major', $major)
                ->where('deleted_account', 0)
                ->count();
        }

        // Language-specific statistics
        $total_courses = $courses->count();
        $vip_courses = $courses->where('is_vip', 1)->count();
        $regular_courses = $courses->where('is_vip', 0)->count();
        $total_enrollments = VipUser::where('major', $major)->where('deleted_account', 0)->count();
        $avg_rating = $courses->avg('rating');
        $avg_rating = $avg_rating ? round($avg_rating, 2) : 0;

        // Language display name mapping
        $languageNames = [
            'english' => 'Easy English',
            'korea' => 'Easy Korean',
            'chinese' => 'Easy Chinese',
            'japanese' => 'Easy Japanese',
            'russian' => 'Easy Russian'
        ];

        $languageName = $languageNames[$major] ?? ucfirst($major);

        return view('courses.coursesbylanguage', [
            'courses' => $courses,
            'major' => $major,
            'language' => $language,
            'languageName' => $languageName,
            'total_courses' => $total_courses,
            'vip_courses' => $vip_courses,
            'regular_courses' => $regular_courses,
            'total_enrollments' => $total_enrollments,
            'avg_rating' => $avg_rating,
        ]);
    }
}

