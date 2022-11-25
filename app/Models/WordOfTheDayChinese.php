<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordOfTheDayChinese extends Model
{
    use HasFactory;
    protected $table="cn_word_of_days";
    public $timestamps=false;
}
