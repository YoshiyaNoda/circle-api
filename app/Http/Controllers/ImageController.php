<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\User;

class ImageController extends Controller
{   
    static public function fetchUserFromToken($req) {
        return User::where('token', $req->token)->first();
    }
    public function retImagesAll($request) {
        $user = self::fetchUserFromToken($request);
        return Image::retImagesAll($user);
    }
    public function uploadImage(Request $request) {
        $user = self::fetchUserFromToken($request);
        if($user) {
            if(Image::articleNumber($user) < 30) { //枚数制限
                return Image::createImageWithReq($request, $user);
            } else {
                return "over";
            }
        }
        return "fail";
    }
}
