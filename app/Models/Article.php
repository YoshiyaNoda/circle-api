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
    // static public function checkAuthorization($callback, $arg) {
    //     $user = User::where('token', $req->token)->first();
    //     if($user->exists()) {
    //         return $callback($arg);
    //     } else {
    //         return null;
    //     }
    // }
    static public function fetchRawHTML($req) {
        return Article::where('user_id', $req->userId)
            ->where('url', $req->articleURL)
            ->value('raw_html');
    }
    static public function saveRawHTML($req) {
        $user = User::where('token', $req->token)->first();
        if($user->exists()) {
            return self::where('id', $req->articleId)
                ->update([
                    'raw_html' => $req->rawHTML
                ]);
        } else {
            return null;
        }
    }
    static public function fetchArticleData($req) {
        $user = User::where('token', $req->token)->first();
        if($user->exists()) {
            return self::find($req->articleId);
        } else {
            return null;
        }
    }
    static public function saveJson($req) {
        $user = User::where('token', $req->token)->first();
        if($user->exists()) {
            return self::where('id', $req->articleId)
                ->update([
                    'json' => $req->articleData
                ]);
        }
        return null;
    }
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
