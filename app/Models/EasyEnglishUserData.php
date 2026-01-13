<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyEnglishUserData extends Model
{
    use HasFactory;
    protected $table="ee_user_datas";
    public $timestamps=false;
    
    protected $fillable = [
        'phone',
        'is_vip',
        'gold_plan',
        'study_time',
        'level_test',
        'basic_exam',
        'game_score',
        'speaking_level',
        'token',
        'login_time',
        'first_join',
        'last_active',
        'song',
        'General',
        'learn_count',
        'discuss_count',
        'auth_token',
    ];
}
