<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GifUser extends Model
{
    use HasFactory;
    protected $table = "gifs_users";
    protected $fillable = ["user_id", "gif_id"];
}
