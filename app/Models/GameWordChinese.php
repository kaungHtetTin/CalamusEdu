<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameWordChinese extends Model
{
    use HasFactory;
    protected $table="cn_game_words";
    public $timestamps=false;
}
