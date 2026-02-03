<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

class ApiUserController extends Controller
{
    /**
     * Get language-specific user data model based on major
     * 
     * @param string $major
     * @return string|null Model class name
     */
    private function getLanguageModel($major)
    {
        $languageMap = [
            'korea' => EasyKoreanUserData::class,
            'english' => EasyEnglishUserData::class,
            'chinese' => EasyChineseUserData::class,
            'japanese' => EasyJapaneseUserData::class,
            'russian' => EasyRussianUserData::class,
        ];
        
        return $languageMap[strtolower($major)] ?? null;
    }
    
    /**
     * Get User VIP Information
     * GET /users/vip/{id}?phone=09123456789&major=korea
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showVipsetting(Request $request, $id)
    {
        try {
            $phone = $request->get('phone');
            $major = $request->get('major', 'korea'); // Default to korea for backward compatibility
            
            if (!$phone) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Phone parameter is required'
                ], 400);
            }
            
            // Validate major
            $validMajors = ['korea', 'english', 'chinese', 'japanese', 'russian'];
            if (!in_array(strtolower($major), $validMajors)) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Invalid major. Must be one of: ' . implode(', ', $validMajors)
                ], 400);
            }
            
            // Get learner information
            $learner = learner::where('learner_phone', $phone)->first();
            
            if (!$learner) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'User not found'
                ], 404);
            }
            
            // Get language-specific user data
            $languageModel = $this->getLanguageModel($major);
            if (!$languageModel) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Invalid language major'
                ], 400);
            }
            
            $languageData = $languageModel::where('phone', $phone)->first();
            
            // Get all main courses for the specified major
            $mainCourses = course::where('major', $major)
                ->select('course_id', 'title', 'major')
                ->get()
                ->map(function ($course) {
                    return [
                        'course_id' => (string) $course->course_id,
                        'title' => $course->title,
                        'major' => $course->major
                    ];
                });
            
            // Get user's VIP course access for the specified major
            $courses = VipUser::where('phone', $phone)
                ->where('major', $major)
                ->pluck('course_id')
                ->map(function ($id) {
                    return (int) $id;
                })
                ->toArray();
            
            // Format languageData response
            $languageDataResponse = [
                'id' => $languageData ? (string) $languageData->id : '',
                'token' => $languageData ? $languageData->token : '',
                'is_vip' => $languageData ? (int) $languageData->is_vip : 0,
                'gold_plan' => $languageData ? (int) $languageData->gold_plan : 0
            ];
            
            // Format learner response
            $learnerResponse = [
                'id' => (string) $learner->id,
                'learner_name' => $learner->learner_name,
                'learner_phone' => (string) $learner->learner_phone,
                'learner_image' => $learner->learner_image ?? ''
            ];
            
            // Build dynamic response - consistent for all languages
            $response = [
                'learner' => $learnerResponse,
                'languageData' => $languageDataResponse,
                'mainCourses' => $mainCourses,
                'courses' => $courses,
                'major' => $major
            ];
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'Server error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Reset User Password
     * POST /users/passwordreset
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required',
                'phone' => 'required',
            ]);
            
            $phone = $request->phone;
            $password = Hash::make($request->password);
            
            $learner = learner::where('learner_phone', $phone)->first();
            
            if (!$learner) {
                if ($request->has('api')) {
                    return response()->json([
                        'status' => 'error',
                        'error' => 'User not found'
                    ], 404);
                }
                return "User not found";
            }
            
            $learner->password = $password;
            $learner->save();
            
            if ($request->has('api')) {
                return "Password reset successfully";
            }
            
            return "Password reset successfully";
            
        } catch (\Exception $e) {
            if ($request->has('api')) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Server error occurred'
                ], 500);
            }
            return "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Add VIP Access to User
     * POST /users/vipadding/{learner_id}
     * 
     * @param Request $request
     * @param int $learner_id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function addVip(Request $request, $learner_id)
    {
        try {
            $learner = learner::find($learner_id);
            
            if (!$learner) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Learner not found'
                ], 404);
            }
            
            $phone = $learner->learner_phone;
            $mainCourses = course::get();
            $paymentAccepted = false;

            // Handle payment
            if ($request->has('amount') && ($request->amount != null && $request->amount != 0)) {
                
                // Validate partner code if provided (do not create PartnerEarning until payment is accepted)
                if ($request->has('partner_code') && $request->partner_code) {
                    $partner = Partner::where('private_code', $request->partner_code)->first();
                    if (!$partner) {
                        return response()->json([
                            'status' => 'error',
                            'error' => 'Wrong promotion code! Activation failed'
                        ], 400);
                    }
                }

                // Handle screenshot upload for API requests
                $screenshot = "";
                $approve = 0;
                
                if ($request->hasFile('myfile')) {
                    $myPath = "https://www.calamuseducation.com/financial/";
                    $file = $request->file('myfile');
                    $result = Storage::disk('calamusFinancial')->put('uploads', $file);
                    $screenshot = $myPath . $result;
                }
                
                // Validate transaction_id if provided (optional)
                if ($request->filled('transaction_id')) {
                    $exists = Payment::where('transaction_id', $request->transaction_id)->exists();
                    if ($exists) {
                        return response()->json([
                            'status' => 'error',
                            'error' => 'This transaction has already been recorded. Duplicate transaction is not allowed.'
                        ], 400);
                    }
                }
                
                // Create payment record
                $payment = new Payment();
                $payment->user_id = $phone;
                $payment->major = $request->major;
                $payment->amount = $request->amount;
                $payment->screenshot = $screenshot;
                $payment->approve = $approve;
                if ($request->filled('transaction_id')) {
                    $payment->transaction_id = $request->transaction_id;
                } else {
                    $payment->transaction_id = 0;
                }
                $payment->save();
                $paymentAccepted = true;

                // Create PartnerEarning only after payment is successfully accepted
                if ($paymentAccepted && $request->has('partner_code') && $request->partner_code) {
                    $partner = Partner::where('private_code', $request->partner_code)->first();
                    if ($partner) {
                        $PartnerEarning = new PartnerEarning();
                        $PartnerEarning->partner_id = $partner->id;
                        $PartnerEarning->target_course_id = null;
                        $PartnerEarning->target_package_id = null;
                        $PartnerEarning->learner_phone = $phone;
                        $PartnerEarning->price = $request->amount;
                        $PartnerEarning->commission_rate = $partner->commission_rate;
                        $original_price = $request->amount / 0.9;  // 10% discount to user
                        $PartnerEarning->amount_received = ($original_price * $partner->commission_rate) / 100;
                        $PartnerEarning->status = 'pending';
                        $PartnerEarning->save();
                    }
                }
            }
            
            // Update VIP status and course access only when payment was successfully accepted
            if (!$paymentAccepted) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Payment is required to activate VIP access.'
                ], 400);
            }

            // Update VIP status based on major
            $major = $request->major;
            
            // Validate major
            $validMajors = ['korea', 'english', 'chinese', 'japanese', 'russian'];
            if (!in_array(strtolower($major), $validMajors)) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Invalid major. Must be one of: ' . implode(', ', $validMajors)
                ], 400);
            }
            
            // Get the appropriate model for the major
            $languageModel = $this->getLanguageModel($major);
            if (!$languageModel) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Invalid language major'
                ], 400);
            }
            
            // Map major to VIP field name
            $vipFieldMap = [
                'korea' => 'vip_korea',
                'english' => 'vip_english',
                'chinese' => 'vip_chinese',
                'japanese' => 'vip_japanese',
                'russian' => 'vip_russian',
            ];
            
            $vipField = $vipFieldMap[strtolower($major)] ?? null;
            
            // Update VIP status
            if ($vipField && $request->has($vipField)) {
                $isVip = ($request->$vipField == "on") ? 1 : 0;
                $languageModel::where('phone', $phone)->update(['is_vip' => $isVip]);
            }
            
            // Update gold plan status (supported for all languages)
            if ($request->has('gold_plan')) {
                $goldPlan = ($request->gold_plan == "on") ? 1 : 0;
                $languageModel::where('phone', $phone)->update(['gold_plan' => $goldPlan]);
            }
            
            // Handle course access grants/revocations
            foreach ($mainCourses as $mainCourse) {
                $courseId = $mainCourse->course_id;
                
                if ($mainCourse->major == $major) {
                    // Check if course_id field exists in request (dynamic field)
                    if ($request->has((string)$courseId) && $request->$courseId == "on") {
                        DB::table('VipUsers')
                            ->updateOrInsert(
                                ['phone' => $phone, 'course_id' => $mainCourse->course_id],
                                ['major' => $mainCourse->major, 'course' => $mainCourse->title]
                            );
                    } else {
                        VipUser::where('phone', $phone)
                            ->where('course_id', $mainCourse->course_id)
                            ->where('major', $mainCourse->major)
                            ->delete();
                    }
                }
            }
            
            return "VIP access activated successfully";
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'Server error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Transfer VIP Access
     * POST /users/transfer-vip-access
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transferVipAccess(Request $request)
    {
        try {
            $request->validate([
                'source' => 'required',
                'target' => 'required',
                'major' => 'required',
            ]);
            
            $source_phone = $request->source;
            $target_phone = $request->target;
            $major = $request->major;
            
            // Check if source and target are the same
            if ($source_phone == $target_phone) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Source and target phone numbers cannot be the same'
                ], 400);
            }
            
            // Get user models based on major
            $sourceUser = null;
            $targetUser = null;
            
            switch ($major) {
                case 'korea':
                    $sourceUser = EasyKoreanUserData::where('phone', $source_phone)->first();
                    $targetUser = EasyKoreanUserData::where('phone', $target_phone)->first();
                    break;
                case 'english':
                    $sourceUser = EasyEnglishUserData::where('phone', $source_phone)->first();
                    $targetUser = EasyEnglishUserData::where('phone', $target_phone)->first();
                    break;
                case 'japanese':
                    $sourceUser = EasyJapaneseUserData::where('phone', $source_phone)->first();
                    $targetUser = EasyJapaneseUserData::where('phone', $target_phone)->first();
                    break;
                case 'chinese':
                    $sourceUser = EasyChineseUserData::where('phone', $source_phone)->first();
                    $targetUser = EasyChineseUserData::where('phone', $target_phone)->first();
                    break;
                case 'russian':
                    $sourceUser = EasyRussianUserData::where('phone', $source_phone)->first();
                    $targetUser = EasyRussianUserData::where('phone', $target_phone)->first();
                    break;
            }
            
            if (!$sourceUser) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Source user not found'
                ], 404);
            }
            
            if (!$targetUser) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Target user not found'
                ], 404);
            }
            
            // Check if source has VIP access
            $source_courses = VipUser::where('major', $major)
                ->where('phone', $source_phone)
                ->get();
            
            if ($source_courses->count() == 0 && $sourceUser->is_vip == 0) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Source account is not a VIP account'
                ], 400);
            }
            
            // Check if target already has VIP access
            $target_courses = VipUser::where('major', $major)
                ->where('phone', $target_phone)
                ->get();
            
            if ($target_courses->count() > 0 || $targetUser->is_vip == 1) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Target account already has VIP access'
                ], 400);
            }
            
            // Transfer VIP courses
            VipUser::where('phone', $source_phone)
                ->where('major', $major)
                ->update(['phone' => $target_phone]);
            
            // Transfer VIP status and gold plan
            $targetUser->is_vip = $sourceUser->is_vip;
            $targetUser->gold_plan = $sourceUser->gold_plan;
            $targetUser->save();
            
            // Revoke VIP from source
            $sourceUser->is_vip = 0;
            $sourceUser->gold_plan = 0;
            $sourceUser->save();
            
            return response()->json([
                'status' => 'success'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'Server error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
