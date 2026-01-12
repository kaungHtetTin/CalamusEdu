<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Report;
use App\Models\mylike;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function showMainPostControllerView(){
        // Get total posts by language
        $english_posts = post::where('major', 'english')->count();
        $korean_posts = post::where('major', 'korea')->count();
        $chinese_posts = post::where('major', 'chinese')->count();
        $japanese_posts = post::where('major', 'japanese')->count();
        $russian_posts = post::where('major', 'russian')->count();
        $total_posts = $english_posts + $korean_posts + $chinese_posts + $japanese_posts + $russian_posts;

        // Get posts with media
        $posts_with_images = post::where('image', '!=', '')->where('has_video', 0)->count();
        $posts_with_videos = post::where('has_video', 1)->count();
        $posts_text_only = post::where('image', '')->where('has_video', 0)->count();

        // Get engagement metrics
        $total_likes = post::sum('post_like');
        $total_comments = post::sum('comments');
        $total_views = post::sum('view_count');
        $total_shares = post::sum('share_count');
        
        // Get reported posts count (distinct post_ids in report table)
        $total_reported_posts = Report::distinct('post_id')->count('post_id');
        
        // Get notifications for admin (user_id 10000) related to comments and replies
        // Action codes: typically 1=comment, 2=reply (adjust based on your notification_action table)
        $adminNotifications = DB::table('notification')
            ->selectRaw("
                notification.id,
                notification.post_id,
                notification.comment_id,
                notification.owner_id,
                notification.writer_id,
                notification.action,
                notification.time,
                notification.seen,
                notification_action.action_name,
                posts.body as post_body,
                posts.image as post_image,
                posts.major,
                comment.body as comment_body,
                comment.parent as comment_parent,
                learners.learner_name as writer_name,
                learners.learner_image as writer_image
            ")
            ->where('notification.owner_id', 10000)
            ->where('notification.action', '<', 5) // Comments and replies (based on NotificationController pattern)
            ->leftJoin('posts', 'posts.post_id', '=', 'notification.post_id')
            ->leftJoin('comment', 'comment.time', '=', 'notification.comment_id')
            ->leftJoin('learners', 'learners.learner_phone', '=', 'notification.writer_id')
            ->leftJoin('notification_action', 'notification_action.action', '=', 'notification.action')
            ->orderBy('notification.time', 'desc')
            ->limit(20)
            ->get();
        
        $unreadNotificationsCount = DB::table('notification')
            ->where('owner_id', 10000)
            ->where('seen', 0)
            ->where('action', '<', 5)
            ->count();

        // Get top posts
        $top_liked_posts = DB::table('posts')
            ->select('posts.post_id', 'posts.body', 'posts.post_like', 'posts.major', 'learners.learner_name')
            ->join('learners', 'learners.learner_phone', '=', 'posts.learner_id')
            ->orderBy('posts.post_like', 'desc')
            ->limit(5)
            ->get();

        $top_commented_posts = DB::table('posts')
            ->select('posts.post_id', 'posts.body', 'posts.comments', 'posts.major', 'learners.learner_name')
            ->join('learners', 'learners.learner_phone', '=', 'posts.learner_id')
            ->orderBy('posts.comments', 'desc')
            ->limit(5)
            ->get();

        $top_viewed_posts = DB::table('posts')
            ->select('posts.post_id', 'posts.body', 'posts.view_count', 'posts.major', 'learners.learner_name')
            ->join('learners', 'learners.learner_phone', '=', 'posts.learner_id')
            ->where('posts.has_video', 1)
            ->orderBy('posts.view_count', 'desc')
            ->limit(5)
            ->get();

        // Get posts over time (last 30 days)
        $posts_over_time = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $start_timestamp = strtotime($date . ' 00:00:00') * 1000;
            $end_timestamp = strtotime($date . ' 23:59:59') * 1000;
            $count = post::whereBetween('post_id', [$start_timestamp, $end_timestamp])->count();
            $posts_over_time[] = [
                'date' => date('M d', strtotime("-$i days")),
                'count' => $count
            ];
        }

        return view('posts.postmain', [
            'english_posts' => $english_posts,
            'korean_posts' => $korean_posts,
            'chinese_posts' => $chinese_posts,
            'japanese_posts' => $japanese_posts,
            'russian_posts' => $russian_posts,
            'total_posts' => $total_posts,
            'posts_with_images' => $posts_with_images,
            'posts_with_videos' => $posts_with_videos,
            'posts_text_only' => $posts_text_only,
            'total_likes' => $total_likes,
            'total_comments' => $total_comments,
            'total_views' => $total_views,
            'total_shares' => $total_shares,
            'total_reported_posts' => $total_reported_posts,
            'adminNotifications' => $adminNotifications,
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'top_liked_posts' => $top_liked_posts,
            'top_commented_posts' => $top_commented_posts,
            'top_viewed_posts' => $top_viewed_posts,
            'posts_over_time' => $posts_over_time
        ]);
    }


    public function showTimeline(Request $req,$major){

        $dataStore=$req->mCode;
        $page=$req->page;
        
        $limit=10;
        $count=($page-1)*$limit;
        
        $dataStore=$dataStore."_user_datas";

        $posts=DB::table('posts')
            ->selectRaw("
                learners.learner_name as userName,
        	    learners.learner_phone as userId,
        	    $dataStore.token as userToken,
        	    learners.learner_image as userImage,
        	    $dataStore.is_vip as vip,
        	    posts.post_id as postId,
        	    posts.body as body,
        	    posts.post_like as postLikes,
        	    posts.comments,
        	    posts.image as postImage,
        	    posts.view_count as viewCount,
                posts.vimeo,
        	    posts.has_video
                ")
        ->where('posts.major',$major)
        ->join('learners','learners.learner_phone','=','posts.learner_id')
        ->join($dataStore,"$dataStore.phone",'=','posts.learner_id')
        ->orderBy('posts.id','desc')
        ->offset($count)
        ->limit($limit)
        ->get();
        
        
        if(!sizeof($posts)==0){
            
            foreach($posts as $post){
                
                $post->is_liked=0;
                $likeRows=mylike::where('content_id',$post->postId)->get();
                
                foreach ($likeRows as $row){
                    
                        $likesArr=json_decode($row->likes,true);
                        $user_ids=array_column($likesArr,"user_id");
                        
                    if(in_array( 10000, $user_ids)){
                        $post->is_liked=1;
                    }
                }
                    $arr[]=$post;
            }
           
        }else{
             $arr=null;
        }
        
        return view('posts.timeline',[
            'posts'=>$arr,
            'mCode'=>$req->mCode,
            'page'=>$req->page,
            'major'=>$req->major
        ]);
    }
    
    public function showCreatePost($major){
        return view('posts.createpost',[
            'major'=>$major
        ]);
    }

    public function uploadVimeo(Request $req){
        $req->validate([
            'post_id'=>'required'
            ]);
        $post_id=$req->post_id;
        $vimeo=$req->vimeo;
        
        post::where('post_id', $post_id)->update(['vimeo'=>$vimeo]);
        return back()->with('msg','Vimeo embedded');
    }
    
    public function addPost(Request $req,$major){
     
        $post_id=$req->post_id;
	    $learner_id=$req->learner_id;
	  
	    if(!empty($req->body)&&isset($req->body)){
	       $body=$req->body;
	    }else{
	        $body="";
	    }

        $imagePath="";
        $myPath="https://www.calamuseducation.com/uploads/";
        $file=$req->file('myfile');
        if(!empty($req->myfile)){
            $result=Storage::disk('calamusPost')->put('posts',$file);
            $imagePath=$myPath.$result;
        }
        
       $post=new post;
       $post->post_id=round(microtime(true) * 1000);
       $post->learner_id=10000;
       $post->body=$body;
       $post->image=$imagePath;
       $post->has_video=0;
       $post->major=$major;
       $post->post_like=0;
       $post->comments=0;
       $post->video_url="";
       $post->vimeo="";
       $post->view_count=0;
       $post->save();
        
        if($major=="korea"){
            $topic="koreaUsers";
        }else if($major=="english"){
            $topic="englishUsers";
        }else if($major=="chinese"){
            $topic="chineseUsers";
        }else if($major=="japanese"){
            $topic="japaneseUsers";
        }else if($major=="russian"){
            $topic="russianUsers";
        }
        
        $payload = array();
        $payload['team'] = 'Calamus';
        $payload['go'] = "cloud_message";

        FirebaseNotiPushController::pushNotificationToTopic($topic,"New Calamus Post",$body,$payload);
        
        return back()->with('msg','Post was successfully added');
    }
    
    public function deletePost($postId){
  
        
        $image =post::where('post_id',$postId)->get();
        
        $image=$image[0]['image'];
        if($image!=""){
            $image = basename($image);
            $file=$_SERVER['DOCUMENT_ROOT'].'/uploads/posts/'.$image;
            if(file_exists($file)){
                unlink($file);
            }
        }
        $mylike=mylike::where('content_id',$postId)->delete();
        $notification=Notification::where('post_id',$postId)->delete();
        $comment = Comment::where('post_id', $postId)->delete();
        $report=Report::where('post_id',$postId)->delete();
        $post=post::where('post_id',$postId)->delete();
       
        return back()->with('msg','Successfully deleted');
    }

    public function showReportedPostsTimeline(Request $req){
        $page = $req->page ?? 1;
        $limit = 10;
        $count = ($page - 1) * $limit;

        // Get distinct reported post IDs with count
        $reportedPostIds = DB::table('report')
            ->select('post_id', DB::raw('COUNT(*) as report_count'))
            ->groupBy('post_id')
            ->orderBy(DB::raw('MAX(id)'), 'desc')
            ->offset($count)
            ->limit($limit)
            ->get();

        $reportedPosts = [];
        
        foreach ($reportedPostIds as $reportedPostId) {
            $post = DB::table('posts')
                ->selectRaw("
                    posts.post_id as postId,
                    posts.body,
                    posts.image as postImage,
                    posts.post_like as postLikes,
                    posts.comments,
                    posts.view_count as viewCount,
                    posts.has_video,
                    posts.vimeo,
                    posts.major,
                    learners.learner_name as userName,
                    learners.learner_phone as userId,
                    learners.learner_image as userImage
                ")
                ->join('learners', 'learners.learner_phone', '=', 'posts.learner_id')
                ->where('posts.post_id', $reportedPostId->post_id)
                ->first();

            if ($post) {
                $post->report_count = $reportedPostId->report_count;
                $reportedPosts[] = $post;
            }
        }

        $totalReported = Report::distinct('post_id')->count('post_id');
        $totalPages = ceil($totalReported / $limit);

        return view('posts.reportedtimeline', [
            'reportedPosts' => $reportedPosts,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalReported' => $totalReported
        ]);
    }

    public function approveReport(Request $request){
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid post ID'
            ], 400);
        }

        $postId = $request->post_id;
        
        // Remove all reports for this post
        $deleted = Report::where('post_id', $postId)->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Report approved. Post is now visible.'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to approve report'
        ], 500);
    }

    public function deleteReportedPost(Request $request){
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid post ID'
            ], 400);
        }

        $postId = $request->post_id;

        // Get post image for deletion
        $post = post::where('post_id', $postId)->first();
        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        // Delete image file if exists
        if (!empty($post->image)) {
            $image = basename($post->image);
            $file = $_SERVER['DOCUMENT_ROOT'] . '/uploads/posts/' . $image;
            if (file_exists($file)) {
                unlink($file);
            }
        }

        // Delete related data
        mylike::where('content_id', $postId)->delete();
        Notification::where('post_id', $postId)->delete();
        Comment::where('post_id', $postId)->delete();
        Report::where('post_id', $postId)->delete();
        post::where('post_id', $postId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ], 200);
    }

    public function showAdminNotifications(Request $request){
        $page = $request->page ?? 1;
        $limit = 20;
        $count = ($page - 1) * $limit;

        // Get notifications for admin (user_id 10000) related to comments and replies
        $adminNotifications = DB::table('notification')
            ->selectRaw("
                notification.id,
                notification.post_id,
                notification.comment_id,
                notification.owner_id,
                notification.writer_id,
                notification.action,
                notification.time,
                notification.seen,
                notification_action.action_name,
                posts.body as post_body,
                posts.image as post_image,
                posts.major,
                comment.body as comment_body,
                comment.parent as comment_parent,
                learners.learner_name as writer_name,
                learners.learner_image as writer_image
            ")
            ->where('notification.owner_id', 10000)
            ->where('notification.action', '<', 5) // Comments and replies
            ->leftJoin('posts', 'posts.post_id', '=', 'notification.post_id')
            ->leftJoin('comment', 'comment.time', '=', 'notification.comment_id')
            ->leftJoin('learners', 'learners.learner_phone', '=', 'notification.writer_id')
            ->leftJoin('notification_action', 'notification_action.action', '=', 'notification.action')
            ->orderBy('notification.time', 'desc')
            ->offset($count)
            ->limit($limit)
            ->get();
        
        $totalNotifications = DB::table('notification')
            ->where('owner_id', 10000)
            ->where('action', '<', 5)
            ->count();
        
        $unreadNotificationsCount = DB::table('notification')
            ->where('owner_id', 10000)
            ->where('seen', 0)
            ->where('action', '<', 5)
            ->count();
        
        $totalPages = ceil($totalNotifications / $limit);

        return view('posts.adminnotifications', [
            'adminNotifications' => $adminNotifications,
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'totalNotifications' => $totalNotifications,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function markNotificationAsRead(Request $request){
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid notification ID'
            ], 400);
        }

        $notificationId = $request->notification_id;
        
        $notification = Notification::where('id', $notificationId)
            ->where('owner_id', 10000)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        $notification->seen = 1;
        $notification->save();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ], 200);
    }



    //api function


    public function fetchMorePost(Request $req,$major){

        $dataStore=$req->mCode;
        $page=$req->page;
        
        $limit=10;
        $count=($page-1)*$limit;
        
        $dataStore=$dataStore."_user_datas";

        $posts=DB::table('posts')
            ->selectRaw("
                    learners.learner_name as userName,
            	    learners.learner_phone as userId,
            	    $dataStore.token as userToken,
            	    learners.learner_image as userImage,
            	    $dataStore.is_vip as vip,
            	    posts.post_id as postId,
            	    posts.body as body,
            	    posts.post_like as postLikes,
            	    posts.comments,
            	    posts.image as postImage,
            	    posts.view_count as viewCount,
                    posts.vimeo,
            	    posts.has_video
            	    
                ")
            ->where('posts.major',$major)
            ->join('learners','learners.learner_phone','=','posts.learner_id')
            ->join($dataStore,"$dataStore.phone",'=','posts.learner_id')
            ->orderBy('posts.id','desc')
            ->offset($count)
            ->limit($limit)
            ->get();
        
        if(!sizeof($posts)==0){
            
            foreach($posts as $post){
                
                $post->is_liked=0;
                $likeRows=mylike::where('content_id',$post->postId)->get();
                
                foreach ($likeRows as $row){
                
                        $likesArr=json_decode($row->likes,true);
                
                        $user_ids=array_column($likesArr,"user_id");
                        
                    if(in_array( 10000, $user_ids)){
                        $post->is_liked=1;
                        
                    }
                }
                    $arr[]=$post;
            }
           
        }else{
             $arr=null;
        }
        
        return $arr;
        
    }

    // ==================== POST CRUD API ====================

    /**
     * Create a new post
     * POST /api/posts
     */
    public function createPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'learner_id' => 'required|integer',
            'body' => 'nullable|string',
            'major' => 'required|string|in:english,korea,chinese,japanese,russian',
            'myfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $post = new post();
            $post->post_id = round(microtime(true) * 1000);
            $post->learner_id = $request->learner_id;
            $post->body = $request->body ?? '';
            $post->major = $request->major;
            $post->post_like = 0;
            $post->comments = 0;
            $post->has_video = 0;
            $post->view_count = 0;
            $post->share_count = 0;
            $post->vimeo = '';
            $post->video_url = '';
            $post->image = '';
            $post->show_on_blog = 0;
            $post->hide = 0;

            // Handle image upload
            if ($request->hasFile('myfile')) {
                $result = Storage::disk('calamusPost')->put('posts', $request->file('myfile'));
                $post->image = 'https://www.calamuseducation.com/uploads/' . $result;
            }

            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => [
                    'post_id' => $post->post_id,
                    'body' => $post->body,
                    'image' => $post->image,
                    'major' => $post->major,
                    'created_at' => $post->post_id
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single post by ID
     * GET /api/posts/{postId}
     */
    public function getPost($postId)
    {
        try {
            $post = post::where('post_id', $postId)->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $post
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a post
     * PUT /api/posts/{postId} or POST /api/posts/{postId} (with _method=PUT)
     */
    public function updatePost(Request $request, $postId)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'nullable|string',
            'myfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            '_method' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $post = post::where('post_id', $postId)->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            if ($request->has('body') || $request->body !== null) {
                $post->body = $request->body ?? '';
            }

            // Handle image removal
            if ($request->has('remove_image') && $request->remove_image == '1') {
                if ($post->image != '') {
                    $oldImage = basename($post->image);
                    $file = $_SERVER['DOCUMENT_ROOT'] . '/uploads/posts/' . $oldImage;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $post->image = '';
            }
            // Handle image upload
            elseif ($request->hasFile('myfile')) {
                // Delete old image if exists
                if ($post->image != '') {
                    $oldImage = basename($post->image);
                    $file = $_SERVER['DOCUMENT_ROOT'] . '/uploads/posts/' . $oldImage;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }

                $result = Storage::disk('calamusPost')->put('posts', $request->file('myfile'));
                $post->image = 'https://www.calamuseducation.com/uploads/' . $result;
            }

            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $post
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a post
     * DELETE /api/posts/{postId}
     */
    public function deletePostApi($postId)
    {
        try {
            $post = post::where('post_id', $postId)->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            // Delete associated image
            if ($post->image != '') {
                $image = basename($post->image);
                $file = $_SERVER['DOCUMENT_ROOT'] . '/uploads/posts/' . $image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            // Delete associated data
            mylike::where('content_id', $postId)->delete();
            Notification::where('post_id', $postId)->delete();
            Comment::where('post_id', $postId)->delete();
            Report::where('post_id', $postId)->delete();
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ==================== POST LIKE API ====================

    /**
     * Like or unlike a post
     * POST /api/posts/like
     */
    public function likePost(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'post_id' => 'required|numeric', // Changed from integer to numeric to handle bigint values
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $userId = (int)$request->user_id;
            $postId = (string)$request->post_id; // Convert to string for bigint comparison

            // Find post by post_id column (not id column)
            // post_id is bigint(20) which can be very large (timestamp in milliseconds)
            // Convert to string for proper bigint comparison
            $post = post::where('post_id', (string)$postId)->first();

           
            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            // Check if like record exists - content_id in mylike table matches post_id from posts table
            $likeRecord = mylike::where('content_id', $postId)->first();

            if ($likeRecord) {
                $likesArr = json_decode($likeRecord->likes, true) ?? [];
                $userIds = array_column($likesArr, 'user_id');
                $userIndex = array_search($userId, $userIds);

                if ($userIndex !== false) {
                    // Unlike: Remove user from likes array
                    unset($likesArr[$userIndex]);
                    $likesArr = array_values($likesArr); // Re-index array
                    $post->post_like = max(0, $post->post_like - 1);
                    $isLiked = false;
                } else {
                    // Like: Add user to likes array
                    $likesArr[] = ['user_id' => $userId];
                    $post->post_like = $post->post_like + 1;
                    $isLiked = true;
                }

                $likeRecord->likes = json_encode($likesArr);
                $likeRecord->save();
            } else {
                // Create new like record
                $likeRecord = new mylike();
                $likeRecord->content_id = $postId;
                $likeRecord->likes = json_encode([['user_id' => $userId]]);
                $likeRecord->rowNo = 0;
                $likeRecord->save();
                $post->post_like = $post->post_like + 1;
                $isLiked = true;
            }

            $post->save();

            // Create notification for like (only when liking, not unliking)
            if ($isLiked && $post->learner_id != $userId) {
                // Check if notification already exists to avoid duplicates
                $existingNotification = Notification::where('post_id', $postId)
                    ->where('owner_id', $post->learner_id)
                    ->where('writer_id', $userId)
                    ->where('action', 0) // Action 0 = like
                    ->where('comment_id', 0)
                    ->first();

                if (!$existingNotification) {
                    $notification = new Notification();
                    $notification->post_id = $postId;
                    $notification->comment_id = 0; // No comment for likes
                    $notification->owner_id = $post->learner_id; // Post owner receives notification
                    $notification->writer_id = $userId; // User who liked
                    $notification->action = 0; // Action 0 = like
                    $notification->time = round(microtime(true) * 1000);
                    $notification->seen = 0;
                    $notification->save();
                }
            } elseif (!$isLiked) {
                // Remove notification when unliking
                Notification::where('post_id', $postId)
                    ->where('owner_id', $post->learner_id)
                    ->where('writer_id', $userId)
                    ->where('action', 0)
                    ->where('comment_id', 0)
                    ->delete();
            }

            return response()->json([
                'success' => true,
                'message' => $isLiked ? 'Post liked' : 'Post unliked',
                'data' => [
                    'count' => $post->post_like,
                    'isLike' => $isLiked
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to like/unlike post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ==================== COMMENT CRUD API ====================

    /**
     * Get comments for a post
     * GET /api/comments/{major}
     */
    public function getComments(Request $request, $major)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $postId = $request->post_id;
            $userId = $request->user_id;

            // Normalize major
            if ($major == 'korea') {
                $major = 'korean';
            }

            $post = post::where('post_id', $postId)->first();
            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            // Get top-level comments
            $comments = DB::table('comment')
                ->selectRaw("
                    comment.id,
                    comment.post_id,
                    comment.writer_id,
                    comment.body,
                    comment.image as commentImage,
                    comment.time,
                    comment.parent,
                    comment.likes,
                    learners.learner_name as userName,
                    learners.learner_image as userImage
                ")
                ->where('comment.post_id', $postId)
                ->where('comment.parent', 0) // Only top-level comments
                ->join('learners', 'learners.learner_phone', '=', 'comment.writer_id')
                ->orderBy('comment.time', 'asc')
                ->get();

            // Get replies for each comment
            foreach ($comments as $comment) {
                $comment->is_liked = 0;
                $commentLike = CommentLike::where('comment_id', $comment->time)
                    ->where('user_id', $userId)
                    ->first();
                if ($commentLike) {
                    $comment->is_liked = 1;
                }
                
                // Fetch replies for this comment
                $replies = DB::table('comment')
                    ->selectRaw("
                        comment.id,
                        comment.post_id,
                        comment.writer_id,
                        comment.body,
                        comment.image as commentImage,
                        comment.time,
                        comment.parent,
                        comment.likes,
                        learners.learner_name as userName,
                        learners.learner_image as userImage
                    ")
                    ->where('comment.post_id', $postId)
                    ->where('comment.parent', $comment->time) // Replies have parent = parent comment's time
                    ->join('learners', 'learners.learner_phone', '=', 'comment.writer_id')
                    ->orderBy('comment.time', 'asc')
                    ->get();
                
                // Check if user liked each reply
                foreach ($replies as $reply) {
                    $reply->is_liked = 0;
                    $replyLike = CommentLike::where('comment_id', $reply->time)
                        ->where('user_id', $userId)
                        ->first();
                    if ($replyLike) {
                        $reply->is_liked = 1;
                    }
                }
                
                $comment->replies = $replies;
            }

            return response()->json([
                'success' => true,
                'post' => [[
                    'postId' => $post->post_id,
                    'userId' => $post->learner_id
                ]],
                'comments' => $comments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch comments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new comment
     * POST /api/comments
     */
    public function createComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'writer_id' => 'required|integer',
            'post_id' => 'required|integer',
            'body' => 'required|string',
            'owner_id' => 'nullable|integer',
            'action' => 'nullable|integer',
            'myfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $post = post::where('post_id', $request->post_id)->first();
            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found'
                ], 404);
            }

            $comment = new Comment();
            $comment->post_id = $request->post_id;
            $comment->writer_id = $request->writer_id;
            $comment->body = $request->body;
            $comment->time = round(microtime(true) * 1000);
            $comment->parent = $request->action ?? 0;
            $comment->likes = 0;
            $comment->image = '';

            // Handle image upload
            if ($request->hasFile('myfile')) {
                $result = Storage::disk('calamusPost')->put('comments', $request->file('myfile'));
                $comment->image = 'https://www.calamuseducation.com/uploads/' . $result;
            }

            $comment->save();

            // Update post comment count
            $post->comments = $post->comments + 1;
            $post->save();

            // Determine if this is a reply or a comment
            $isReply = $request->action && $request->action > 0;
            $actionCode = $isReply ? 2 : 1; // 1 = comment, 2 = reply
            
            // For comments: notify the post owner
            // For replies: notify the comment owner (parent comment writer)
            $notificationOwnerId = null;
            
            if ($isReply) {
                // This is a reply - notify the parent comment owner
                $parentComment = Comment::where('time', $request->action)->first();
                if ($parentComment && $parentComment->writer_id != $request->writer_id) {
                    $notificationOwnerId = $parentComment->writer_id;
                }
            } else {
                // This is a comment - notify the post owner
                if ($post->learner_id != $request->writer_id) {
                    $notificationOwnerId = $post->learner_id;
                }
            }

            // Create notification for comment or reply
            if ($notificationOwnerId) {
                $notification = new Notification();
                $notification->post_id = $request->post_id;
                $notification->comment_id = $comment->time; // Use comment time as comment_id
                $notification->owner_id = $notificationOwnerId; // Who receives the notification
                $notification->writer_id = $request->writer_id; // Who wrote the comment/reply
                $notification->action = $actionCode; // 1 = comment, 2 = reply
                $notification->time = round(microtime(true) * 1000);
                $notification->seen = 0;
                $notification->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Comment created successfully',
                'data' => [
                    'id' => $comment->id,
                    'post_id' => $comment->post_id,
                    'body' => $comment->body,
                    'time' => $comment->time
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a comment
     * PUT /api/comments/{commentId}
     */
    public function updateComment(Request $request, $commentId)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
            'myfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $comment = Comment::find($commentId);
            if (!$comment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not found'
                ], 404);
            }

            $comment->body = $request->body;

            // Handle image upload
            if ($request->hasFile('myfile')) {
                // Delete old image if exists
                if ($comment->image != '') {
                    $oldImage = basename($comment->image);
                    $file = $_SERVER['DOCUMENT_ROOT'] . '/uploads/comments/' . $oldImage;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }

                $result = Storage::disk('calamusPost')->put('comments', $request->file('myfile'));
                $comment->image = 'https://www.calamuseducation.com/uploads/' . $result;
            }

            $comment->save();

            return response()->json([
                'success' => true,
                'message' => 'Comment updated successfully',
                'data' => $comment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a comment
     * DELETE /api/comments/{commentId}
     */
    public function deleteComment($commentId)
    {
        try {
            // Comment ID is the time field (timestamp)
            $comment = Comment::where('time', $commentId)->first();
            if (!$comment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not found'
                ], 404);
            }

            $postId = $comment->post_id;

            // Delete comment image if exists
            if ($comment->image != '') {
                $image = basename($comment->image);
                $file = $_SERVER['DOCUMENT_ROOT'] . '/uploads/comments/' . $image;
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            // Delete comment likes (comment_id in comment_likes table is the comment's time field)
            CommentLike::where('comment_id', $comment->time)->delete();

            // Delete child comments (replies) if this is a parent comment
            Comment::where('parent', $comment->time)->delete();

            // Delete the comment
            $comment->delete();

            // Update post comment count (count all remaining comments for this post)
            $post = post::where('post_id', $postId)->first();
            if ($post) {
                $remainingComments = Comment::where('post_id', $postId)->count();
                $post->comments = $remainingComments;
                $post->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ==================== COMMENT LIKE API ====================

    /**
     * Like or unlike a comment
     * POST /api/comments/like
     */
    public function likeComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
            'comment_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $userId = $request->user_id;
            $commentId = $request->comment_id; // This is the comment's time field

            $comment = Comment::where('time', $commentId)->first();
            if (!$comment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Comment not found'
                ], 404);
            }

            // Check if user already liked this comment
            $commentLike = CommentLike::where('comment_id', $commentId)
                ->where('user_id', $userId)
                ->first();

            if ($commentLike) {
                // Unlike: Delete the like record
                $commentLike->delete();
                $comment->likes = max(0, $comment->likes - 1);
                $isLiked = false;
            } else {
                // Like: Create new like record
                $commentLike = new CommentLike();
                $commentLike->comment_id = $commentId;
                $commentLike->user_id = $userId;
                $commentLike->save();
                $comment->likes = $comment->likes + 1;
                $isLiked = true;
            }

            $comment->save();

            return response()->json([
                'success' => true,
                'message' => $isLiked ? 'Comment liked' : 'Comment unliked',
                'data' => [
                    'count' => $comment->likes,
                    'isLike' => $isLiked
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to like/unlike comment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
