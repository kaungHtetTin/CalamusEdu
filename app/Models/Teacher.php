<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    
    protected $table = 'teachers';
    
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'profile',
        'rank',
        'facebook',
        'telegram',
        'youtube',
        'description',
        'qualification',
        'experience',
        'total_course'
    ];
}

