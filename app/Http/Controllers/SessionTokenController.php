<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionTokenController extends Controller
{
    public function SessionToken(Request $request){
        $token = $request->session()->get('user_token');
        return $token;
    }
}
