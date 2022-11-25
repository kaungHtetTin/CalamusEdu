<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameWordJapanese extends Model
{
    use HasFactory;
    protected $table="jp_game_words";
    public $timestamps=false;
}
