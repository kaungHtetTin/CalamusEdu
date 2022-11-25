<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordOfTheDayJapanese extends Model
{
    use HasFactory;
    protected $table="jp_word_of_days";
    public $timestamps=false;
}
