<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUserName(Request $request) {
        return User::getUser($request->token);
    }
}
