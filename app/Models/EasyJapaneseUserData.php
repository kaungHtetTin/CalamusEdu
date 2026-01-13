<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyJapaneseUserData extends Model
{
    use HasFactory;
    protected $table = 'jp_user_datas';
    public $timestamps = false;
    
    protected $fillable = [
        'phone',
        'is_vip',
        'gold_plan',
        'study_time',
        'basic_exam',
        'game_score',
        'token',
        'login_time',
        'first_join',
        'last_active',
        'song',
        'discuss_count',
        'learn_count',
        'auth_token',
    ];
}
