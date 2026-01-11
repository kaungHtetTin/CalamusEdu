<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lesson;
use App\Models\post;
use App\Models\mylike;
use App\Models\Studyplan;
use App\Models\Notification;
use App\Models\LessonCategory;
use App\Services\LanguageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function showLessonMain(){
        // Lesson Statistics
        $total_lessons = lesson::count();
        
        // Lessons by language
        $english_lessons = lesson::where('major', 'english')->count();
        $korean_lessons = lesson::where('major', 'korea')->count();
        $chinese_lessons = lesson::where('major', 'chinese')->count();
        $japanese_lessons = lesson::where('major', 'japanese')->count();
        $russian_lessons = lesson::where('major', 'russian')->count();
        
        // Video vs Non-Video lessons
        $video_lessons = lesson::where('isVideo', 1)->count();
        $non_video_lessons = lesson::where('isVideo', 0)->count();
        
        // VIP vs Regular lessons
        $vip_lessons = lesson::where('isVip', 1)->count();
        $regular_lessons = lesson::where('isVip', 0)->count();
        
        // Total categories
        $total_categories = DB::table('lessons_categories')->select('id')->distinct()->count();
        
        // Categories by language
        $english_categories = DB::table('lessons_categories')->where('major', 'english')->select('id')->distinct()->count();
        $korean_categories = DB::table('lessons_categories')->where('major', 'korea')->select('id')->distinct()->count();
        $chinese_categories = DB::table('lessons_categories')->where('major', 'chinese')->select('id')->distinct()->count();
        $japanese_categories = DB::table('lessons_categories')->where('major', 'japanese')->select('id')->distinct()->count();
        $russian_categories = DB::table('lessons_categories')->where('major', 'russian')->select('id')->distinct()->count();
        
        return view('lessons.lessonmain', [
            'total_lessons' => $total_lessons,
            'english_lessons' => $english_lessons,
            'korean_lessons' => $korean_lessons,
            'chinese_lessons' => $chinese_lessons,
            'japanese_lessons' => $japanese_lessons,
            'russian_lessons' => $russian_lessons,
            'video_lessons' => $video_lessons,
            'non_video_lessons' => $non_video_lessons,
            'vip_lessons' => $vip_lessons,
            'regular_lessons' => $regular_lessons,
            'total_categories' => $total_categories,
            'english_categories' => $english_categories,
            'korean_categories' => $korean_categories,
            'chinese_categories' => $chinese_categories,
            'japanese_categories' => $japanese_categories,
            'russian_categories' => $russian_categories,
        ]);
    }


    public function showLessonCategory($language){
        // Validate language parameter using LanguageService
        if (!LanguageService::isValidCode($language)) {
            abort(404, 'Invalid language');
        }

        $major = $language;

        // Fetch courses with categories for the language
        $courses = DB::table('courses')
            ->select('courses.*', 'lessons_categories.*')
            ->join('lessons_categories', 'lessons_categories.course_id', '=', 'courses.course_id')
            ->where('lessons_categories.major', $major)
            ->orderBy('courses.course_id')
            ->orderBy('lessons_categories.sort_order')
            ->get();

        // Organize courses by course_id
        $myCourses = [];
        foreach($courses as $course){
            if (!isset($myCourses[$course->course_id])) {
                // Calculate statistics for this course
                $courseCategories = DB::table('lessons_categories')
                    ->where('course_id', $course->course_id)
                    ->orderBy('sort_order')
                    ->pluck('id')
                    ->toArray();
                
                $totalCourseLessons = lesson::whereIn('category_id', $courseCategories)->count();
                $videoCourseLessons = lesson::whereIn('category_id', $courseCategories)->where('isVideo', 1)->count();
                $documentCourseLessons = lesson::whereIn('category_id', $courseCategories)->where('isVideo', 0)->count();
                
                $myCourses[$course->course_id] = [
                    'title' => $course->title,
                    'course_id' => $course->course_id,
                    'total_lessons' => $totalCourseLessons,
                    'video_lessons' => $videoCourseLessons,
                    'document_lessons' => $documentCourseLessons,
                    'data' => []
                ];
            }
            $myCourses[$course->course_id]['data'][] = $course;
        }

        // Language-specific statistics
        $total_lessons = lesson::where('major', $major)->count();
        $video_lessons = lesson::where('major', $major)->where('isVideo', 1)->count();
        $non_video_lessons = lesson::where('major', $major)->where('isVideo', 0)->count();
        $vip_lessons = lesson::where('major', $major)->where('isVip', 1)->count();
        $regular_lessons = lesson::where('major', $major)->where('isVip', 0)->count();
        $total_categories = DB::table('lessons_categories')
            ->where('major', $major)
            ->select('id')
            ->distinct()
            ->count();
        $total_courses = count($myCourses);

        // Get language display name from LanguageService
        $languageName = LanguageService::getDisplayName($language);
        
        return view('lessons.lessons', [
            'language' => $language,
            'languageName' => $languageName,
            'major' => $major,
            'myCourses' => $myCourses,
            'total_lessons' => $total_lessons,
            'video_lessons' => $video_lessons,
            'non_video_lessons' => $non_video_lessons,
            'vip_lessons' => $vip_lessons,
            'regular_lessons' => $regular_lessons,
            'total_categories' => $total_categories,
            'total_courses' => $total_courses,
        ]);
    }

    public function showAddCourse($language){
        // Validate language parameter using LanguageService
        if (!LanguageService::isValidCode($language)) {
            abort(404, 'Invalid language');
        }

        // Get language display name from LanguageService
        $languageName = LanguageService::getDisplayName($language);

        // Get teachers for dropdown
        $teachers = DB::table('teachers')->select('id', 'name')->get();

        return view('lessons.addcourse', [
            'language' => $language,
            'languageName' => $languageName,
            'major' => $language,
            'teachers' => $teachers,
        ]);
    }

    public function addCourse(Request $req, $language){
        // Validate language parameter using LanguageService
        if (!LanguageService::isValidCode($language)) {
            abort(404, 'Invalid language');
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
        ]);

        // Get the next course_id
        $maxCourseId = DB::table('courses')->max('course_id');
        $courseId = ($maxCourseId ?? 0) + 1;

        // Handle cover image upload
        $coverUrl = '';
        if ($req->hasFile('cover_image')) {
            $coverFile = $req->file('cover_image');
            $coverPath = Storage::disk('calamusPost')->put('courses/covers', $coverFile);
            $baseUrl = env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads');
            $coverUrl = rtrim($baseUrl, '/') . '/' . $coverPath;
        }

        // Handle web cover image upload
        $webCoverUrl = '';
        if ($req->hasFile('web_cover_image')) {
            $webCoverFile = $req->file('web_cover_image');
            $webCoverPath = Storage::disk('calamusPost')->put('courses/web-covers', $webCoverFile);
            $baseUrl = env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads');
            $webCoverUrl = rtrim($baseUrl, '/') . '/' . $webCoverPath;
        }

        try {
            // Insert new course
            DB::table('courses')->insert([
                'course_id' => $courseId,
                'teacher_id' => $req->teacher_id,
                'title' => $req->title,
                'certificate_title' => $req->certificate_title,
                'lessons_count' => 0,
                'cover_url' => $coverUrl,
                'web_cover' => $webCoverUrl,
                'description' => $req->description,
                'details' => $req->details,
                'is_vip' => $req->has('is_vip') ? 1 : 0,
                'duration' => $req->duration,
                'background_color' => $req->background_color,
                'fee' => $req->fee,
                'enroll' => 0,
                'rating' => 0,
                'major' => $language,
                'sorting' => 0,
                'preview' => '', // Preview will be handled in edit functionality
                'certificate_code' => $req->certificate_code,
            ]);

            return back()->with('success', 'Course created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create course: ' . $e->getMessage())->withInput();
        }
    }

    public function showAddCategory($language, $course){
        // Validate language parameter using LanguageService
        if (!LanguageService::isValidCode($language)) {
            abort(404, 'Invalid language');
        }

        // Get course info
        $courseInfo = DB::table('courses')->where('course_id', $course)->first();
        if (!$courseInfo) {
            abort(404, 'Course not found');
        }

        // Get language display name from LanguageService
        $languageName = LanguageService::getDisplayName($language);

        return view('lessons.addcategory', [
            'language' => $language,
            'languageName' => $languageName,
            'course_id' => $course,
            'course_title' => $courseInfo->title,
            'major' => $language,
        ]);
    }

    public function addCategory(Request $req, $language, $course){
        // Validate language parameter using LanguageService
        if (!LanguageService::isValidCode($language)) {
            abort(404, 'Invalid language');
        }

        $req->validate([
            'category_title' => 'required|string|max:128',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Handle category image upload
        $imageUrl = '';
        if ($req->hasFile('category_image')) {
            $imageFile = $req->file('category_image');
            $imagePath = Storage::disk('calamusPost')->put('lessons/categories', $imageFile);
            $baseUrl = env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads');
            $imageUrl = rtrim($baseUrl, '/') . '/' . $imagePath;
        }

        // Get the next category id
        $maxCategoryId = DB::table('lessons_categories')->max('id');
        $categoryId = ($maxCategoryId ?? 0) + 1;

        // Generate category code from title (use title as category code, truncated to 128 chars)
        $categoryCode = substr($req->category_title, 0, 128);

        // Insert new category
        DB::table('lessons_categories')->insert([
            'id' => $categoryId,
            'course_id' => $course,
            'category' => $categoryCode,
            'category_title' => $req->category_title,
            'image_url' => $imageUrl,
            'sort_order' => round(microtime(true) * 1000),
            'major' => $language,
        ]);

        return redirect()->route('lessons.byLanguage', $language)
            ->with('success', 'Category created successfully!');
    }

    public function showEditCategory($id){
        $category = DB::table('lessons_categories')->where('id', $id)->first();
        
        if (!$category) {
            abort(404, 'Category not found');
        }

        // Get course info
        $courseInfo = DB::table('courses')->where('course_id', $category->course_id)->first();
        if (!$courseInfo) {
            abort(404, 'Course not found');
        }

        // Get language display name from LanguageService
        $languageName = LanguageService::getDisplayName($category->major);

        return view('lessons.editcategory', [
            'category' => $category,
            'language' => $category->major,
            'languageName' => $languageName,
            'course_id' => $category->course_id,
            'course_title' => $courseInfo->title,
            'major' => $category->major,
        ]);
    }

    public function updateCategory(Request $req, $id){
        $category = DB::table('lessons_categories')->where('id', $id)->first();
        
        if (!$category) {
            abort(404, 'Category not found');
        }

        $req->validate([
            'category_title' => 'required|string|max:128',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $updateData = [
            'category_title' => $req->category_title,
            // Update category code from title (use title as category code, truncated to 128 chars)
            'category' => substr($req->category_title, 0, 128),
        ];

        // Handle category image upload
        if ($req->hasFile('category_image')) {
            // Delete old image if exists
            if ($category->image_url) {
                $oldPath = str_replace(env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads') . '/', '', $category->image_url);
                if (Storage::disk('calamusPost')->exists($oldPath)) {
                    Storage::disk('calamusPost')->delete($oldPath);
                }
            }
            
            $imageFile = $req->file('category_image');
            $imagePath = Storage::disk('calamusPost')->put('lessons/categories', $imageFile);
            $baseUrl = env('COURSE_IMAGES_BASE_URL', env('APP_URL', 'https://www.calamuseducation.com') . '/uploads');
            $updateData['image_url'] = rtrim($baseUrl, '/') . '/' . $imagePath;
        }

        // Update category
        DB::table('lessons_categories')
            ->where('id', $id)
            ->update($updateData);

        return redirect()->route('lessons.byLanguage', $category->major)
            ->with('success', 'Category updated successfully!');
    }

    public function showSortCategories($language, $course){
        // Validate language parameter using LanguageService
        if (!LanguageService::isValidCode($language)) {
            abort(404, 'Invalid language');
        }

        // Get course info
        $courseInfo = DB::table('courses')->where('course_id', $course)->first();
        if (!$courseInfo) {
            abort(404, 'Course not found');
        }

        // Get categories for this course, ordered by current sort_order
        $categories = DB::table('lessons_categories')
            ->where('course_id', $course)
            ->where('major', $language)
            ->orderBy('sort_order')
            ->get();

        // Get language display name from LanguageService
        $languageName = LanguageService::getDisplayName($language);

        return view('lessons.sortcategories', [
            'language' => $language,
            'languageName' => $languageName,
            'course_id' => $course,
            'course_title' => $courseInfo->title,
            'categories' => $categories,
            'major' => $language,
        ]);
    }

    public function updateSortCategories(Request $req, $language, $course){
        // Validate language parameter using LanguageService
        if (!LanguageService::isValidCode($language)) {
            abort(404, 'Invalid language');
        }

        $req->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|integer',
            'categories.*.sort_order' => 'required|integer|min:0',
        ]);

        // Update sort order for each category
        foreach ($req->categories as $categoryData) {
            DB::table('lessons_categories')
                ->where('id', $categoryData['id'])
                ->where('course_id', $course)
                ->where('major', $language)
                ->update(['sort_order' => (int)$categoryData['sort_order']]);
        }

        return redirect()->route('lessons.byLanguage', $language)
            ->with('success', 'Category sorting updated successfully!');
    }

    public function showLessonList(Request $req,$category_id){

        $lessons=lesson::where('category_id',$category_id)
        ->orderBy('isVideo','desc')
        ->orderBy('id')
        ->get();

        $category=LessonCategory::where('id',$category_id)->first();
        return view('lessons.lessonlist',[
            'lessons'=>$lessons,
            'category_id'=>$category_id,
            'cate'=>$req->cate,
            'icon'=>$category->image_url
        ]);
    }

    public function viewVideoLesson($id){
        $lesson=lesson::find($id);

    
        $post=DB::table('posts')
        ->selectRaw("
        	    posts.post_like as postLikes,
        	    posts.post_id,
        	    posts.comments,
        	    posts.view_count,
        	    posts.video_url,
        	    posts.vimeo,
        	    posts.learner_id
        	    
            ")
        ->where('posts.post_id',$lesson->date)
        ->first();
              
        $post->is_liked=0;
        // Check if admin (learner_phone 10000) has liked this post
        $likeRows=mylike::where('content_id',$post->post_id)->get();

        foreach ($likeRows as $row){
                     
            $likesArr=json_decode($row->likes,true);
            
            $user_ids=array_column($likesArr,"user_id");
                     
                if(in_array( "10000", $user_ids)){
                    $post->is_liked=1;
                        
                }
        }
        
        // Get admin user info (learner_phone 10000) for comment display
        $adminUser = DB::table('learners')
            ->where('learner_phone', 10000)
            ->select('learner_name', 'learner_image')
            ->first();
            

        $comments=DB::table('comment')
	    ->selectRaw('
	        comment.id,
	        learners.learner_name as userName,
    	    learners.learner_image as userImage,
    	    comment.body,
    	    comment.time,
    	    comment.writer_id as userId,
    	    comment.parent
	        ')
	    ->where('comment.post_id',$lesson->date)
	    ->where('comment.parent', 0)
	    ->join('learners','learners.learner_phone','=','comment.writer_id')
	    ->orderBy('comment.time')
	    ->get();
	    
	    // Get replies for each comment
	    foreach($comments as $comment) {
	        $replies = DB::table('comment')
	            ->selectRaw('
	                comment.id,
	                learners.learner_name as userName,
	                learners.learner_image as userImage,
	                comment.body,
	                comment.time,
	                comment.writer_id as userId
	                ')
	            ->where('comment.post_id', $lesson->date)
	            ->where('comment.parent', $comment->id)
	            ->join('learners','learners.learner_phone','=','comment.writer_id')
	            ->orderBy('comment.time')
	            ->get();
	        $comment->replies = $replies;
	    }
        
        return view('lessons.videolesson',[
        'lesson'=>$lesson,
        'post'=>$post,
        'comments'=>$comments,
        'adminUser'=>$adminUser
        ]);
    }

    public function viewBlogLesson($id){
        $lesson=lesson::find($id);
        $lessonData=file_get_contents($lesson->link);
        $lessonData=json_decode($lessonData);
        return view('lessons.bloglesson',['lessonData'=>$lessonData]);
    }


   public function showAddLesson($course){
       return view('lessons.addlesson',[
           'course'=>$course
       ]);
   }

   public function showAddVideoLesson($course){
       // $course is actually a category_id when called from the modal
       $category = LessonCategory::where('id', $course)->first();
       
       if (!$category) {
           abort(404, 'Category not found');
       }

       // Get course info
       $courseInfo = DB::table('courses')->where('course_id', $category->course_id)->first();
       if (!$courseInfo) {
           abort(404, 'Course not found');
       }

       // Get all categories for this course (for category selection)
       $categories = DB::table('lessons_categories')
           ->where('course_id', $courseInfo->course_id)
           ->where('major', $category->major)
           ->orderBy('sort_order')
           ->get();

       // Store categories in session for the view
       $lessonArr = [];
       foreach($categories as $cat) {
           $lessonArr[] = (object)[
               'id' => $cat->id,
               'category_title' => $cat->category_title
           ];
       }
       session()->put($courseInfo->title, $lessonArr);
       session()->put('major', $category->major);

       return view('lessons.addvideolesson',[
           'course'=>$courseInfo->title
       ]);
   }

   public function showAddDocumentLesson($course){
       // $course is actually a category_id when called from the modal
       $category = LessonCategory::where('id', $course)->first();
       
       if (!$category) {
           abort(404, 'Category not found');
       }

       // Get course info
       $courseInfo = DB::table('courses')->where('course_id', $category->course_id)->first();
       if (!$courseInfo) {
           abort(404, 'Course not found');
       }

       // Get all categories for this course (for category selection)
       $categories = DB::table('lessons_categories')
           ->where('course_id', $courseInfo->course_id)
           ->where('major', $category->major)
           ->orderBy('sort_order')
           ->get();

       // Store categories in session for the view
       $lessonArr = [];
       foreach($categories as $cat) {
           $lessonArr[] = (object)[
               'id' => $cat->id,
               'category_title' => $cat->category_title
           ];
       }
       session()->put($courseInfo->title, $lessonArr);
       session()->put('major', $category->major);

       return view('lessons.adddocumentlesson',[
           'course'=>$courseInfo->title
       ]);
   }

   public function showEditLesson($id){
       $lesson = lesson::find($id);
       
       if (!$lesson) {
           abort(404, 'Lesson not found');
       }

       // Get category info
       $category = LessonCategory::where('id', $lesson->category_id)->first();
       if (!$category) {
           abort(404, 'Category not found');
       }

       // Get course info to get categories list
       $courseInfo = DB::table('courses')
           ->select('courses.*')
           ->join('lessons_categories', 'lessons_categories.course_id', '=', 'courses.course_id')
           ->where('lessons_categories.id', $lesson->category_id)
           ->first();

       if (!$courseInfo) {
           abort(404, 'Course not found');
       }

       // Get all categories for this course (for category selection)
       $categories = DB::table('lessons_categories')
           ->where('course_id', $courseInfo->course_id)
           ->where('major', $lesson->major)
           ->orderBy('sort_order')
           ->get();

       // Get post data
       $post = DB::table('posts')->where('post_id', $lesson->date)->first();

       // Store categories in session for the view (like in showAddLesson)
       $lessonArr = [];
       foreach($categories as $cat) {
           $lessonArr[] = (object)[
               'id' => $cat->id,
               'category_title' => $cat->category_title
           ];
       }
       session()->put($courseInfo->title, $lessonArr);
       session()->put('major', $lesson->major);

       return view('lessons.editlesson', [
           'lesson' => $lesson,
           'post' => $post,
           'category' => $category,
           'course' => $courseInfo->title,
           'categories' => $categories,
       ]);
   }

    public function updateLesson(Request $req, $id){
        $lesson = lesson::find($id);
        
        if (!$lesson) {
            abort(404, 'Lesson not found');
        }

        $req->validate([
            'title_mini' => 'required',
            'title' => 'required',
            'link' => 'required',
            'post' => 'required',
            'cate' => 'required'
        ]);

        $title_mini = $req->title_mini;
        $title = $req->title;
        $link = $req->link;
        $body = $req->post;
        $categoryId = $req->cate;
        $isVideo = (isset($req->isVideo)) ? 1 : 0;
        $isChannel = (isset($req->isChannel)) ? 1 : 0;
        $isVip = (isset($req->isVip)) ? 1 : 0;
        $add_to_discuss = (isset($req->add_to_discuss)) ? 0 : 1;
        $major = $req->major;

        $imagePath = $lesson->thumbnail;
        $vimeo = "";
        $isVideoLesson = $lesson->isVideo;
        $isVideoPost = 0;

        if(isset($req->isVideo)){
            $isVideoLesson = 1;
            $vimeo = $req->vimeo ?? "";
            $myPath = "https://www.calamuseducation.com/uploads/";
            $file = $req->file('myfile');
            if(!empty($req->myfile)){
                // Delete old thumbnail if exists
                if ($lesson->thumbnail) {
                    $oldPath = str_replace($myPath, '', $lesson->thumbnail);
                    if (Storage::disk('calamusPost')->exists($oldPath)) {
                        Storage::disk('calamusPost')->delete($oldPath);
                    }
                }
                $result = Storage::disk('calamusPost')->put('posts', $file);
                $imagePath = $myPath . $result;
            }
            
            // For post: isVideo = 0 if VIP, otherwise 1
            $isVideoPost = ($isVip == 1) ? 0 : 1;
        } else {
            $isVideoLesson = 0;
            $imagePath = "";
            $templink = $req->link;
            // Parse blog link if it contains "edit/"
            if(strpos($templink, "edit/") !== false) {
                $templink = substr($templink, strpos($templink, "edit/") + 5);
                $blogId = substr($templink, 0, 19);
                $blogPostId = substr($templink, 20);
                $link = "https://www.blogger.com/feeds/" . $blogId . "/posts/default/" . $blogPostId . "?alt=json";
            } else {
                // Link is already in correct format (JSON feed URL)
                $link = $req->link;
            }
            $isVideoPost = 0;
        }

        // Update lesson
        $updateData = [
            'category_id' => $categoryId,
            'isVideo' => $isVideoLesson,
            'isVip' => $isVip,
            'isChannel' => $isChannel,
            'link' => $link,
            'title' => $title,
            'title_mini' => $title_mini,
            'thumbnail' => $imagePath,
        ];
        
        lesson::where('id', $id)->update($updateData);

        // Update post
        $postUpdateData = [
            'body' => $body,
            'image' => $imagePath,
            'has_video' => $isVideoPost,
            'vimeo' => $vimeo,
            'hide' => $add_to_discuss,
        ];
        
        DB::table('posts')->where('post_id', $lesson->date)->update($postUpdateData);

        return redirect()->route('lessons.list', $categoryId)->with('msgLesson', 'Lesson was successfully updated');
    }

    public function addLesson(Request $req,$course){

        $req->validate([
            'title_mini'=>'required',
            'title'=>'required',
            'link'=>'required',
            'post'=>'required',
            'cate'=>'required'
        ]);
        
       
        $title_mini=$req->title_mini;
        $title=$req->title;
        $link=$req->link;
        $body=$req->post;
        $categoryId=$req->cate;
        $isVideo=(isset($req->isVideo))?1:0;
        $isChannel=(isset($req->isChannel))?1:0;
        $isVip=(isset($req->isVip))?1:0;
        $add_to_discuss=(isset($req->add_to_discuss))?0:1;
        $date = round(microtime(true) * 1000);
        $major=$req->major;
        
        if($isChannel==1){
            LessonCategory::where('id', $categoryId)->update(['sort_order'=>$date]);
        }
 
        
        $course=DB::table('courses')
            ->selectRaw("courses.course_id,courses.title,courses.background_color")
            ->join("lessons_categories","courses.course_id","=","lessons_categories.course_id")
            ->join("lessons","lessons_categories.id","=","lessons.category_id")
            ->where("lessons.category_id",$categoryId)->limit(1)->get();
            
        if(count($course)==1){
            $course_id= $course[0]->course_id;
            
            DB::table('courses')->where('course_id',$course_id)->update([
                'lessons_count'=>DB::raw("lessons_count+1")
            ]);
                   
        } 
            
            
        $imagePath="";
        $vimeo="";
    
        $isVideoLesson=0;
        
        if(isset($req->isVideo)){
            $vimeo=$req->vimeo;
            $myPath="https://www.calamuseducation.com/uploads/";
            $file=$req->file('myfile');
            if(!empty($req->myfile)){
                $result=Storage::disk('calamusPost')->put('posts',$file);
                $imagePath=$myPath.$result;
            }
            
            if($isVip==1){
                $isVideo=0; // for post
            }
            
             $isVideoLesson=1; // for lesson
            
        }else{
            $imagePath="";
            $templink=$req->link;
            $templink=substr($templink,strpos($templink, "edit/")+5);
            $blogId=substr($templink,0,19);
            $blogPostId=substr($templink,20);
            $link="https://www.blogger.com/feeds/".$blogId."/posts/default/".$blogPostId."?alt=json";
            
        }
  
    
        // Get notification owner ID from LanguageService
        $noti_owner = LanguageService::getNotificationOwnerId($major) ?? '1000';
    
    
        $lesson=new lesson;
        $lesson->cate="";
        $lesson->category_id=$categoryId;
        $lesson->date=$date;
        $lesson->isVideo=$isVideoLesson;
        $lesson->isVip=$isVip;
        $lesson->isChannel=$isChannel;
        $lesson->link=$link;
        $lesson->title=$title;
        $lesson->title_mini=$title_mini;
        $lesson->major=$major;
        $lesson->thumbnail=$imagePath;
        $lesson->save();
        
        $post=new post;
        $post->post_id=$date;
        $post->learner_id=10000;
        $post->body=$body;
        $post->post_like=0;
        $post->comments=0;
        $post->image=$imagePath;
        $post->video_url="";
        $post->has_video=$isVideo;
        $post->vimeo=$vimeo;
        $post->view_count=0;
        $post->major=$major;
        $post->hide=$add_to_discuss;
        $post->save();
        
        
    
        $notification=new Notification;
        $notification->post_id=$date;
        $notification->comment_id=0;
        $notification->owner_id=$noti_owner;
        $notification->writer_id='10000';
        $notification->action=2;
        $notification->time=$date;
        $notification->seen=2;
        $notification->save();

        // Get Firebase topic from LanguageService
        $topic = LanguageService::getFirebaseTopic($req->major);
        
        if (!$topic) {
            // Fallback: generate topic name from major
            $topic = $req->major . "Users";
        }
        
        $payload = array();
        $payload['team'] = 'Calamus';
        $payload['go'] = "new_lesson";
        $payload['course_id']=$course_id;
        $payload['course_title']=$course[0]->title;
        $payload['theme_color']=$course[0]->background_color;

        FirebaseNotiPushController::pushNotificationToTopic($topic,"New Lesson",$body,$payload);
        
        return back()->with('msgLesson','Lesson was successfully added');

    }
    
    public function uploadVideoForLessonDownload(Request $req){
        $req->validate([
            'myfile'=>'required'
            ]);
        
        $post_id=$req->postid;
        $myPath="https://www.calamuseducation.com/uploads/";
        $file=$req->file('myfile');
        $result=Storage::disk('calamusPost')->put('videos',$file);
        $url=$myPath.$result;
        post::where('post_id', $post_id)->update(['video_url'=>$url]);
        return back()->with('msg','Video was successfully added');
    }
    
    public function addLessonToStudyPlan(Request $req){
        
        // $req->validate([
        //     'day'=>'required'
        //     ]);
        $lesson_id=$req->id;
        $day=$req->day;
        $duration=$req->duration;
        
     
        
        if($day!=null){
            $course_id=DB::table('courses')
                ->selectRaw("courses.course_id")
                ->join("lessons_categories","courses.course_id","=","lessons_categories.course_id")
                ->join("lessons","lessons_categories.id","=","lessons.category_id")
                ->where("lessons.id",$lesson_id)->limit(1)->get();
             $course_id= $course_id[0]->course_id;
            
            $studyplan=new Studyplan();
            $studyplan->course_id=$course_id;
            $studyplan->lesson_id=$lesson_id;
            $studyplan->day=$day;
            $studyplan->save();
        }
        
        if($duration!=null){
            lesson::where('id', $lesson_id)->update(['duration'=>$duration]);
        }
      
        
        return back()->with('msg','Success');
    }

    public function updateVideoDuration(Request $req){
        
        $date=$req->date;
        $duration=$req->duration;
        lesson::where('date', $date)->update(['duration'=>$duration]);

    }
    
    public function updateLectureNote(Request $req){
        
        $req->validate([
                'lesson_id'=>'required',
                'hour'=>'required',
                'minute'=>'required',
                'second'=>'required',
                'note'=>'required',
            ]);
        
        $lesson_id = $req->lesson_id;
        $hour = $req->hour;
        $minute = $req->minute;
        $second = $req->second;
        $note = $req->note;
        
        $time = $hour*60*60 + $minute*60 + $second;
        
        $lesson = lesson::find($lesson_id);
        
        $notes = json_decode($lesson->notes, true);
        $newnote = [
                'time'=>$time,
                'note'=> $note,
            ];
        $notes[] = $newnote;
        
        $lesson->notes = json_encode($notes);
        $lesson->save();
        
        return back()->with('msg','Success');
        
    }
 
}
