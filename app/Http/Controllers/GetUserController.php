<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class GetUserController extends Controller
{
    public function getUser(Request $request){
        $token = $request->session()->get('user_token');
        $name=DB::table('users')->where('token', $token)->value('name');
        $email=DB::table('users')->where('token', $token)->value('email');
        return ['name' => $name,'email' => $email];
    }
}
