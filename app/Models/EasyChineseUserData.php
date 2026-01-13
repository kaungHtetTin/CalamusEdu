<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyChineseUserData extends Model
{
    use HasFactory;
    protected $table="cn_user_datas";
    public $timestamps=false;
    
    protected $fillable = [
        'phone',
        'is_vip',
        'study_time',
        'game_score',
        'basic_exam',
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
