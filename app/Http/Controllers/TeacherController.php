<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers
     */
    public function index(Request $req)
    {
        $teachers = Teacher::orderBy('id', 'desc')->simplepaginate(20);
        $teacher_count = Teacher::count();
        
        return view('teachers.index', [
            'teachers' => $teachers,
            'teacher_count' => $teacher_count
        ]);
    }

    /**
     * Show the form for creating a new teacher
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created teacher
     */
    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:225',
            'rank' => 'required|string|max:30',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facebook' => 'nullable|url|max:1000',
            'telegram' => 'nullable|url|max:1000',
            'youtube' => 'nullable|url|max:1000',
            'description' => 'nullable|string',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|string',
            'total_course' => 'nullable|integer|min:0'
        ]);

        $teacher = new Teacher();
        $teacher->name = $req->name;
        $teacher->rank = $req->rank;
        $teacher->facebook = $req->facebook ?? '';
        $teacher->telegram = $req->telegram ?? '';
        $teacher->youtube = $req->youtube ?? '';
        $teacher->description = $req->description ?? '';
        $teacher->qualification = $req->qualification ?? '';
        $teacher->experience = $req->experience ?? '';
        $teacher->total_course = $req->total_course ?? 0;
        
        // Handle profile image upload
        if ($req->hasFile('profile')) {
            $profileImage = $req->file('profile');
            $profileName = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
            $profileImage->move(public_path('uploads/teachers'), $profileName);
            $teacher->profile = 'uploads/teachers/' . $profileName;
        } else {
            $teacher->profile = '';
        }
        
        $teacher->save();

        return redirect()->route('teachers.index')->with('success', 'Teacher was successfully added');
    }

    /**
     * Display the specified teacher
     */
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        
        return view('teachers.show', [
            'teacher' => $teacher
        ]);
    }

    /**
     * Show the form for editing the specified teacher
     */
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        
        return view('teachers.edit', [
            'teacher' => $teacher
        ]);
    }

    /**
     * Update the specified teacher
     */
    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string|max:225',
            'rank' => 'required|string|max:30',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facebook' => 'nullable|url|max:1000',
            'telegram' => 'nullable|url|max:1000',
            'youtube' => 'nullable|url|max:1000',
            'description' => 'nullable|string',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|string',
            'total_course' => 'nullable|integer|min:0'
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->name = $req->name;
        $teacher->rank = $req->rank;
        $teacher->facebook = $req->facebook ?? '';
        $teacher->telegram = $req->telegram ?? '';
        $teacher->youtube = $req->youtube ?? '';
        $teacher->description = $req->description ?? '';
        $teacher->qualification = $req->qualification ?? '';
        $teacher->experience = $req->experience ?? '';
        $teacher->total_course = $req->total_course ?? 0;
        
        // Handle profile image upload
        if ($req->hasFile('profile')) {
            // Delete old profile image if exists
            if ($teacher->profile && file_exists(public_path($teacher->profile))) {
                unlink(public_path($teacher->profile));
            }
            
            $profileImage = $req->file('profile');
            $profileName = time() . '_' . uniqid() . '.' . $profileImage->getClientOriginalExtension();
            $profileImage->move(public_path('uploads/teachers'), $profileName);
            $teacher->profile = 'uploads/teachers/' . $profileName;
        }
        
        $teacher->save();

        return redirect()->route('teachers.index')->with('success', 'Teacher was successfully updated');
    }

    /**
     * Remove the specified teacher
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        
        // Delete profile image if exists
        if ($teacher->profile && file_exists(public_path($teacher->profile))) {
            unlink(public_path($teacher->profile));
        }
        
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher was successfully deleted');
    }
}

