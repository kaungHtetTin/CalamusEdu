<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'display_name',
        'module_code',
        'primary_color',
        'secondary_color',
        'image_path',
        'notification_owner_id',
        'firebase_topic',
        'user_data_table_prefix',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get all active languages
     */
    public static function active()
    {
        return static::where('is_active', true)->orderBy('sort_order')->get();
    }

    /**
     * Get language by code
     */
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * Get user data table name
     */
    public function getUserDataTableName()
    {
        return $this->user_data_table_prefix . '_user_datas';
    }
}

