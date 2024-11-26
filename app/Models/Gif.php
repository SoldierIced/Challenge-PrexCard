<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gif extends Model
{
    use HasFactory;

    protected $table = 'gifs';

    protected $fillable = [
        'id',
        'url',
        'slug',
        'embed_url',
        'username',
        'source',
        'title',
        'source_tld',
        'alt_text',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function users()
    {
        return $this->belongsToMany(User::class, 'gif_user', 'gif_id', 'user_id');
    }
}
