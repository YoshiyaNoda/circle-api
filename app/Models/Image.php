<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $guarded = [];

    static public function articleNumber($user) {
        return self::where('user_id', $user->id)->count();
    }
    static public function createImageWithReq($req, $user) {
        try {
            $path = Storage::disk(config('const_env.STORAGE_DISK'))
                ->putFile('user'.(string)$user->id, $req->image);
            return $path;
        } catch(\Exception $e) {
            // \Log::info("Image create error=".print_r($e, true));
            return "fail";
        }
    }
}
