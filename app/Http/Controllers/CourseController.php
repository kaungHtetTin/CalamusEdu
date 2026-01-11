<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\course;
use App\Models\VipUser;
use App\Services\LanguageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\VimeoService;

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
        // Validate language parameter using LanguageService
        if (!LanguageService::isValidCode($language)) {
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

        // Get language display name from LanguageService
        $languageName = LanguageService::getDisplayName($major);

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

    public function edit($courseId){
        $course = course::where('course_id', $courseId)->first();
        
        if (!$course) {
            abort(404, 'Course not found');
        }

        // Get language display name from LanguageService
        $languageName = LanguageService::getDisplayName($course->major);

        // Get teachers for dropdown
        $teachers = DB::table('teachers')->select('id', 'name')->get();

        return view('courses.edit', [
            'course' => $course,
            'language' => $course->major,
            'languageName' => $languageName,
            'teachers' => $teachers,
        ]);
    }

    public function update(Request $req, $courseId){
        $course = course::where('course_id', $courseId)->first();
        
        if (!$course) {
            abort(404, 'Course not found');
        }

        $req->validate([
            'title' => 'required|string|max:50',
            'teacher_id' => 'required|integer',
            'description' => 'required|string|max:1000',
            'details' => 'required|string',
            'certificate_title' => 'required|string|max:225',
            'certificate_code' => 'required|string|max:5',
            'background_color' => 'required|string|max:225',
            'duration' => 'required|integer|min:1',
            'fee' => 'required|integer|min:0',
            'is_vip' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'web_cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'preview' => 'nullable|string|max:1000',
            'preview_file' => 'nullable|file|mimes:mp4,webm,ogg,mov,avi',
            'vimeo_video_id' => 'nullable|string',
        ]);

        try {
            $updateData = [
                'teacher_id' => $req->teacher_id,
                'title' => $req->title,
                'certificate_title' => $req->certificate_title,
                'description' => $req->description,
                'details' => $req->details,
                'is_vip' => $req->has('is_vip') ? 1 : 0,
                'duration' => $req->duration,
                'background_color' => $req->background_color,
                'fee' => $req->fee,
                'certificate_code' => $req->certificate_code,
            ];

            // Handle cover image upload
            if ($req->hasFile('cover_image')) {
                // Delete old cover image if exists
                if ($course->cover_url) {
                    $oldPath = str_replace(env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads') . '/', '', $course->cover_url);
                    if (Storage::disk('calamusPost')->exists($oldPath)) {
                        Storage::disk('calamusPost')->delete($oldPath);
                    }
                }
                
                $coverFile = $req->file('cover_image');
                $coverPath = Storage::disk('calamusPost')->put('courses/covers', $coverFile);
                $baseUrl = env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads');
                $updateData['cover_url'] = rtrim($baseUrl, '/') . '/' . $coverPath;
            }

            // Handle web cover image upload
            if ($req->hasFile('web_cover_image')) {
                // Delete old web cover image if exists
                if ($course->web_cover) {
                    $oldPath = str_replace(env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads') . '/', '', $course->web_cover);
                    if (Storage::disk('calamusPost')->exists($oldPath)) {
                        Storage::disk('calamusPost')->delete($oldPath);
                    }
                }
                
                $webCoverFile = $req->file('web_cover_image');
                $webCoverPath = Storage::disk('calamusPost')->put('courses/web-covers', $webCoverFile);
                $baseUrl = env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads');
                $updateData['web_cover'] = rtrim($baseUrl, '/') . '/' . $webCoverPath;
            }

            // Handle preview (URL, Vimeo upload, or file upload)
            if ($req->has('preview') && !empty($req->preview)) {
                $updateData['preview'] = $req->preview;
            } elseif ($req->has('vimeo_video_id') && !empty($req->vimeo_video_id)) {
                // Vimeo video ID provided - construct Vimeo URL
                $updateData['preview'] = 'https://vimeo.com/' . $req->vimeo_video_id;
            } elseif ($req->hasFile('preview_file')) {
                // Upload to Vimeo using service
                try {
                    $vimeoService = new VimeoService();
                    $playerUrl = $vimeoService->uploadVideo(
                        $req->file('preview_file'),
                        $course->title . ' - Preview',
                        [$course->major, $course->title, 'Preview']
                    );
                    $updateData['preview'] = $playerUrl;
                } catch (\Exception $e) {
                    return back()->with('error', 'Vimeo upload failed: ' . $e->getMessage())->withInput();
                }
            } else {
                // Keep existing preview if not provided
                $updateData['preview'] = $course->preview;
            }

            // Update course
            DB::table('courses')
                ->where('course_id', $courseId)
                ->update($updateData);

            return back()->with('success', 'Course updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update course: ' . $e->getMessage())->withInput();
        }
    }

}

