<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $guarded = [];

    static public function retImagesAll($user) {
        return self::where('user_id', $user->id)->get(['read_path']);
    }
    static public function articleNumber($user) {
        return self::where('user_id', $user->id)->count();
    }
    static public function createImageWithReq($req, $user) {
        try {
            $path = Storage::disk(config('const_env.STORAGE_DISK'))
                ->putFile('user'.(string)$user->id, $req->image);
            $readPath = '';
            if(config('const_env.STORAGE_DISK') === 'public') {
                $readPath = config('const_env.IMAGE_URL')."/"."storage/".$path;
            } else {
                $readPath = "s3".$path;
            }
            self::create([
                'user_id' => $user->id,
                'storage_path' => $path,
                'read_path' => $readPath
            ]);
            return self::retImagesAll($user);
        } catch(\Exception $e) {
            \Log::info("Image create error=".print_r($e, true));
            return "fail";
        }
    }
}
