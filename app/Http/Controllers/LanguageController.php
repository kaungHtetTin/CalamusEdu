<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Services\LanguageService;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    /**
     * Display a listing of languages
     */
    public function index()
    {
        $languages = Language::orderBy('sort_order')->get();
        
        return view('languages.index', [
            'languages' => $languages,
        ]);
    }

    /**
     * Show the form for creating a new language
     */
    public function create()
    {
        return view('languages.create');
    }

    /**
     * Store a newly created language
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:languages,code',
            'display_name' => 'required|string|max:100',
            'module_code' => 'required|string|max:10|unique:languages,module_code',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'image_path' => 'nullable|string|max:500',
            'notification_owner_id' => 'nullable|string|max:20',
            'firebase_topic' => 'nullable|string|max:100',
            'user_data_table_prefix' => 'required|string|max:20',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $language = Language::create([
            'name' => $request->name,
            'code' => strtolower($request->code),
            'display_name' => $request->display_name,
            'module_code' => strtolower($request->module_code),
            'primary_color' => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'image_path' => $request->image_path,
            'notification_owner_id' => $request->notification_owner_id,
            'firebase_topic' => $request->firebase_topic,
            'user_data_table_prefix' => strtolower($request->user_data_table_prefix),
            'is_active' => $request->has('is_active') ? true : false,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        // Clear cache
        LanguageService::clearCache();

        return redirect()->route('languages.index')
            ->with('success', 'Language created successfully!');
    }

    /**
     * Display the specified language
     */
    public function show($id)
    {
        $language = Language::findOrFail($id);
        
        return view('languages.show', [
            'language' => $language,
        ]);
    }

    /**
     * Show the form for editing the specified language
     */
    public function edit($id)
    {
        $language = Language::findOrFail($id);
        
        return view('languages.edit', [
            'language' => $language,
        ]);
    }

    /**
     * Update the specified language
     */
    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:languages,code,' . $id,
            'display_name' => 'required|string|max:100',
            'module_code' => 'required|string|max:10|unique:languages,module_code,' . $id,
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'image_path' => 'nullable|string|max:500',
            'notification_owner_id' => 'nullable|string|max:20',
            'firebase_topic' => 'nullable|string|max:100',
            'user_data_table_prefix' => 'required|string|max:20',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $language->update([
            'name' => $request->name,
            'code' => strtolower($request->code),
            'display_name' => $request->display_name,
            'module_code' => strtolower($request->module_code),
            'primary_color' => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'image_path' => $request->image_path,
            'notification_owner_id' => $request->notification_owner_id,
            'firebase_topic' => $request->firebase_topic,
            'user_data_table_prefix' => strtolower($request->user_data_table_prefix),
            'is_active' => $request->has('is_active') ? true : false,
            'sort_order' => $request->sort_order ?? $language->sort_order,
        ]);

        // Clear cache
        LanguageService::clearCache();

        return redirect()->route('languages.index')
            ->with('success', 'Language updated successfully!');
    }

    /**
     * Remove the specified language
     */
    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        
        // Check if language is being used
        $lessonsCount = DB::table('lessons')->where('major', $language->code)->count();
        $categoriesCount = DB::table('lessons_categories')->where('major', $language->code)->count();
        
        if ($lessonsCount > 0 || $categoriesCount > 0) {
            return redirect()->route('languages.index')
                ->with('error', 'Cannot delete language. It is being used by ' . ($lessonsCount + $categoriesCount) . ' records.');
        }

        $language->delete();
        
        // Clear cache
        LanguageService::clearCache();

        return redirect()->route('languages.index')
            ->with('success', 'Language deleted successfully!');
    }
}

