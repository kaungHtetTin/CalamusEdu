<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\learner;

class AdminProfileController extends Controller
{
    /**
     * Show the admin profile settings page
     */
    public function index()
    {
        $adminPhone = session('admin_phone');
        
        if (!$adminPhone || $adminPhone != 10000) {
            return redirect()->route('admin.login');
        }

        $admin = DB::table('learners')
            ->where('learner_phone', 10000)
            ->first();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Admin user not found.');
        }

        return view('admin.profile', compact('admin'));
    }

    /**
     * Update admin profile (name, image)
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $adminPhone = session('admin_phone');
        
        if (!$adminPhone || $adminPhone != 10000) {
            return redirect()->route('admin.login');
        }

        $admin = DB::table('learners')
            ->where('learner_phone', 10000)
            ->first();

        if (!$admin) {
            return back()->with('error', 'Admin user not found.');
        }

        $updateData = [
            'learner_name' => $request->name,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'admin_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store in public/uploads/admin directory
            $imagePath = $image->storeAs('uploads/admin', $imageName, 'public');
            
            // Delete old image if exists (handle both full URLs and relative paths)
            if ($admin->learner_image) {
                $oldImagePath = $admin->learner_image;
                // If it's a full URL, extract the path
                if (strpos($oldImagePath, 'http') === 0) {
                    $oldImagePath = str_replace(asset('storage/'), '', $oldImagePath);
                    $oldImagePath = str_replace(url('/storage/'), '', $oldImagePath);
                }
                // Remove leading slash if present
                $oldImagePath = ltrim($oldImagePath, '/');
                
                // Try to delete from storage
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            
            // Store full URL path for consistency
            $updateData['learner_image'] = asset('storage/' . $imagePath);
        }

        // Update database
        DB::table('learners')
            ->where('learner_phone', 10000)
            ->update($updateData);

        // Update session
        session(['admin_name' => $updateData['learner_name']]);
        if (isset($updateData['learner_image'])) {
            session(['admin_image' => $updateData['learner_image']]);
        } else {
            // Keep existing image in session if not updated
            $updatedAdmin = DB::table('learners')->where('learner_phone', 10000)->first();
            if ($updatedAdmin && $updatedAdmin->learner_image) {
                session(['admin_image' => $updatedAdmin->learner_image]);
            }
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $adminPhone = session('admin_phone');
        
        if (!$adminPhone || $adminPhone != 10000) {
            return redirect()->route('admin.login');
        }

        $admin = DB::table('learners')
            ->where('learner_phone', 10000)
            ->first();

        if (!$admin) {
            return back()->with('error', 'Admin user not found.');
        }

        // Verify current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        // Update password
        DB::table('learners')
            ->where('learner_phone', 10000)
            ->update([
                'password' => Hash::make($request->new_password)
            ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
