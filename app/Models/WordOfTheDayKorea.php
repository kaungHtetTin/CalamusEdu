<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordOfTheDayKorea extends Model
{
    use HasFactory;
    protected $table="ko_word_of_days";
    public $timestamps=false;
}
