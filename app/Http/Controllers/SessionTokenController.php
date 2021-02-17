<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SessionTokenController extends Controller
{
    public function SessionToken(Request $request){
        $token = $request->session()->get('user_token');
        $queries=User::getUser($token);
        return $queries;
    }
}
