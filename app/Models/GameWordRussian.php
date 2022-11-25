<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameWordRussian extends Model
{
    use HasFactory;
    protected $table="ru_game_words";
    public $timestamps=false;
}
