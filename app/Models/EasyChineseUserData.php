<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasyChineseUserData extends Model
{
    use HasFactory;
    protected $table="cn_user_datas";
    public $timestamps=false;
}
