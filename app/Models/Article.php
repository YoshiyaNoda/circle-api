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
        'url',
        'title',
    ];
    static public function fetchArticleList($token) {
        return \DB::table('users')
            ->select('articles.id', 'articles.title')
            ->where('users.token', '=', $token)
            ->join('articles', 'users.id', '=', 'articles.user_id')
            ->get();
    }
}
