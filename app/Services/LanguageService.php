<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Facades\Cache;

class LanguageService
{
    /**
     * Cache key for languages
     */
    const CACHE_KEY = 'languages.all';
    const CACHE_KEY_ACTIVE = 'languages.active';
    const CACHE_TTL = 3600; // 1 hour

    /**
     * Get all languages
     */
    public static function all()
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            try {
                return Language::orderBy('sort_order')->get();
            } catch (\Exception $e) {
                // If table doesn't exist yet, return empty collection
                return collect([]);
            }
        });
    }

    /**
     * Get all active languages
     */
    public static function active()
    {
        return Cache::remember(self::CACHE_KEY_ACTIVE, self::CACHE_TTL, function () {
            try {
                return Language::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();
            } catch (\Exception $e) {
                // If table doesn't exist yet, return empty collection
                return collect([]);
            }
        });
    }

    /**
     * Get language by code
     */
    public static function findByCode($code)
    {
        $languages = self::all();
        return $languages->firstWhere('code', $code);
    }

    /**
     * Get language display name by code
     */
    public static function getDisplayName($code)
    {
        $language = self::findByCode($code);
        return $language ? $language->display_name : ucfirst($code);
    }

    /**
     * Get valid language codes
     */
    public static function getValidCodes()
    {
        $codes = self::active()->pluck('code')->toArray();
        
        // Fallback to known languages if database is empty (backward compatibility)
        if (empty($codes)) {
            return ['english', 'korea', 'chinese', 'japanese', 'russian'];
        }
        
        return $codes;
    }

    /**
     * Validate language code
     * Checks both active languages and all languages in database for flexibility
     */
    public static function isValidCode($code)
    {
        // First check active languages
        $activeCodes = self::getValidCodes();
        if (in_array($code, $activeCodes)) {
            return true;
        }
        
        // Also check if language exists in database (even if inactive) for backward compatibility
        $allLanguages = self::all();
        $exists = $allLanguages->firstWhere('code', $code);
        
        if ($exists) {
            return true;
        }
        
        // Fallback: check against known valid languages (backward compatibility)
        $knownLanguages = ['english', 'korea', 'chinese', 'japanese', 'russian'];
        return in_array($code, $knownLanguages);
    }

    /**
     * Get language mapping array (for backward compatibility)
     */
    public static function getLanguageMapping()
    {
        $languages = self::active();
        $mapping = [];
        
        foreach ($languages as $language) {
            $mapping[$language->code] = [
                'name' => $language->display_name,
                'code' => $language->code,
                'module_code' => $language->module_code,
                'primary_color' => $language->primary_color,
                'secondary_color' => $language->secondary_color,
                'image_path' => $language->image_path,
                'notification_owner_id' => $language->notification_owner_id,
                'firebase_topic' => $language->firebase_topic,
                'user_data_table_prefix' => $language->user_data_table_prefix,
                'user_data_table' => $language->getUserDataTableName(),
            ];
        }
        
        return $mapping;
    }

    /**
     * Get language by module code
     */
    public static function findByModuleCode($moduleCode)
    {
        $languages = self::all();
        return $languages->firstWhere('module_code', $moduleCode);
    }

    /**
     * Get notification owner ID for language
     */
    public static function getNotificationOwnerId($code)
    {
        $language = self::findByCode($code);
        return $language ? $language->notification_owner_id : null;
    }

    /**
     * Get Firebase topic for language
     */
    public static function getFirebaseTopic($code)
    {
        $language = self::findByCode($code);
        return $language ? $language->firebase_topic : null;
    }

    /**
     * Get user data table name for language
     */
    public static function getUserDataTableName($code)
    {
        $language = self::findByCode($code);
        return $language ? $language->getUserDataTableName() : null;
    }

    /**
     * Clear language cache
     */
    public static function clearCache()
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::CACHE_KEY_ACTIVE);
    }

    /**
     * Get language configuration for a specific code
     */
    public static function getLanguageConfig($code)
    {
        $language = self::findByCode($code);
        
        if (!$language) {
            return null;
        }

        return [
            'id' => $language->id,
            'name' => $language->name,
            'code' => $language->code,
            'display_name' => $language->display_name,
            'module_code' => $language->module_code,
            'primary_color' => $language->primary_color,
            'secondary_color' => $language->secondary_color,
            'image_path' => $language->image_path,
            'notification_owner_id' => $language->notification_owner_id,
            'firebase_topic' => $language->firebase_topic,
            'user_data_table_prefix' => $language->user_data_table_prefix,
            'user_data_table' => $language->getUserDataTableName(),
            'is_active' => $language->is_active,
        ];
    }

    /**
     * Get user data model class for a language code
     * Returns the model class name based on language code
     */
    public static function getUserDataModelClass($code)
    {
        $modelMap = [
            'english' => \App\Models\EasyEnglishUserData::class,
            'korea' => \App\Models\EasyKoreanUserData::class,
            'korean' => \App\Models\EasyKoreanUserData::class,
            'chinese' => \App\Models\EasyChineseUserData::class,
            'japanese' => \App\Models\EasyJapaneseUserData::class,
            'russian' => \App\Models\EasyRussianUserData::class,
        ];

        return $modelMap[$code] ?? null;
    }

    /**
     * Get complete language mapping including model classes
     * This is a helper for controllers that need model mappings
     */
    public static function getLanguageMappingWithModels($code)
    {
        $language = self::findByCode($code);
        
        if (!$language) {
            return null;
        }

        $modelClass = self::getUserDataModelClass($code);

        return [
            'code' => $language->code,
            'name' => $language->name,
            'display_name' => $language->display_name,
            'module_code' => $language->module_code,
            'major' => $language->code, // For backward compatibility
            'table' => $language->getUserDataTableName(),
            'table_prefix' => $language->user_data_table_prefix,
            'model' => $modelClass,
            'primaryColor' => $language->primary_color,
            'secondaryColor' => $language->secondary_color,
            'image_path' => $language->image_path,
            'notification_owner_id' => $language->notification_owner_id,
            'firebase_topic' => $language->firebase_topic,
        ];
    }
}

