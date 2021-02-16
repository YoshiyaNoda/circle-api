<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $fillable = [
        'name',
        'token',
        'email',
        'provider',
    ]; 

    protected $hidden = [ 'token' ];

    static public function createOrUpdateOnCallback($queries) {
        self::updateOrCreate(
            ['email' => $queries["email"]],
            [
                'email' => $queries["email"],
                'name' => $queries["name"],
                'token' => $queries["token"],
                'provider' => $queries["provider"]
            ]
        );
    }

    static public function getUser($token) {
        $queries=DB::table('users')->where('token', $token)->get();
        return $queries;
    }

}
  