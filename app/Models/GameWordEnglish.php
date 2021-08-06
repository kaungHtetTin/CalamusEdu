<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameWordEnglish extends Model
{
    use HasFactory;
    protected $table="ee_game_words";
    public $timestamps=false;
}
