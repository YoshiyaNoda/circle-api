<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $casts = [
        'json' => 'json'
    ];
    protected $fillable = [
        'json',
        'user_id',
        'raw_html',
        'url'
    ];
}
