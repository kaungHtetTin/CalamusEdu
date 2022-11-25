<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordOfTheDayRussian extends Model
{
    use HasFactory;
    protected $table="ru_word_of_days";
    public $timestamps=false;
}
