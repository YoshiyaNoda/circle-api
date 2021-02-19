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
    protected static $user_id_crypt_key = "mange";
    // static public function checkAuthorization($callback, $arg) {
    //     $user = User::where('token', $req->token)->first();
    //     if($user->exists()) {
    //         return $callback($arg);
    //     } else {
    //         return null;
    //     }
    // }
    static public function fetchRawHTML($req) {
        $encrypted_user_id = $req->encrypted_user_id;
        $userId = openssl_decrypt(hex2bin($encrypted_user_id), 'AES-128-ECB', self::$user_id_crypt_key);
        return Article::where('user_id', $userId)
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
        // sessionにuserIdが入っているので、それをopenssl+hex2bin+bin2hexで暗号化して返す
        if($user->exists()) {
            $article = self::find($req->articleId);
            $article->encrypted_user_id = bin2hex(openssl_encrypt($article->user_id, 'AES-128-ECB', self::$user_id_crypt_key));
            return $article;
        } else {
            return null;
        }
    }
    static public function saveArticleData($req) {
        $user = User::where('token', $req->token)->first();
        if($user->exists()) {
            return self::where('id', $req->articleId)
                ->update([
                    'json' => $req->articleData,
                    'url' => $req->url,
                    'title' => $req->title
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
