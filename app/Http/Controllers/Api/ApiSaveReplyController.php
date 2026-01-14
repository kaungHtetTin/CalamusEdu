<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaveReply;
use Illuminate\Support\Facades\Validator;

class ApiSaveReplyController extends Controller
{
    /**
     * Get All Save Replies
     * GET /save-replies
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $replies = SaveReply::all();
            
            // Format response to match API documentation
            $formattedReplies = $replies->map(function ($reply) {
                return [
                    'id' => (string) $reply->id,
                    'title' => $reply->title,
                    'message' => $reply->message,
                    'major' => $reply->major
                ];
            });
            
            return response()->json($formattedReplies);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'Server error occurred'
            ], 500);
        }
    }
    
    /**
     * Create Save Reply
     * POST /save-replies
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate input - accept both query params and form data
            $title = $request->get('title');
            $message = $request->get('message');
            $major = $request->get('major');
            
            // Validation
            $validator = Validator::make([
                'title' => $title,
                'message' => $message,
                'major' => $major
            ], [
                'title' => 'required|string|max:255',
                'message' => 'required|string|max:1000',
                'major' => 'required|string'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'error' => $validator->errors()->first()
                ], 400);
            }
            
            $saveReply = new SaveReply();
            $saveReply->title = $title;
            $saveReply->message = $message;
            $saveReply->major = $major;
            $saveReply->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Save reply created successfully'
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'Server error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Show Save Reply
     * GET /save-replies/{id}
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $reply = SaveReply::find($id);
            
            if (!$reply) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Save reply not found'
                ], 404);
            }
            
            return response()->json([
                'id' => (string) $reply->id,
                'title' => $reply->title,
                'message' => $reply->message,
                'major' => $reply->major
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'Server error occurred'
            ], 500);
        }
    }
    
    /**
     * Update Save Reply
     * PUT /save-replies/{id}
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $reply = SaveReply::find($id);
            
            if (!$reply) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Save reply not found'
                ], 404);
            }
            
            // Accept data from query params or form data
            $title = $request->get('title', $reply->title);
            $message = $request->get('message', $reply->message);
            $major = $request->get('major', $reply->major);
            
            // Validation
            $validator = Validator::make([
                'title' => $title,
                'message' => $message,
                'major' => $major
            ], [
                'title' => 'required|string|max:255',
                'message' => 'required|string|max:1000',
                'major' => 'required|string'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'error' => $validator->errors()->first()
                ], 400);
            }
            
            $reply->title = $title;
            $reply->message = $message;
            $reply->major = $major;
            $reply->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Save reply updated successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'Server error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete Save Reply
     * DELETE /save-replies/{id}
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $reply = SaveReply::find($id);
            
            if (!$reply) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Save reply not found'
                ], 404);
            }
            
            $reply->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Save reply deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'Server error occurred'
            ], 500);
        }
    }
}
