<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordOfTheDayEnglish extends Model
{
    use HasFactory;
    protected $table="WordOfDay";
    public $timestamps=false;
}
