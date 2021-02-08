<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
    static public function createWithReq($req) {
        $user = User::where('token', $req->token)->first();
        if($user->exists()) {
            $userId = $user->id;
            return self::create([
                'user_id' => $userId,
                'title' => $req->title,
                'url' => $req->url,
            ])->id;
        } else {
            return null;
        }
    }
    static public function fetchArticleList($token) {
        return \DB::table('users')
            ->select('articles.id', 'articles.title')
            ->where('users.token', '=', $token)
            ->join('articles', 'users.id', '=', 'articles.user_id')
            ->get();
    }
}
