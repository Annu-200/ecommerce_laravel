<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Color extends Model
{
    use HasApiTokens;

   protected $guarded = [];
}
