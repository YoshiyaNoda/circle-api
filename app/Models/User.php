<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'token',
        'email'
    ]; 

    protected $hidden = [ 'token' ]; 

    static public function createOrUpdateOnCallback($queries) {
        self::updateOrCreate(
            ['email' => $queries->email],
            [
                'email' => $queries->email,
                'name' => $queries->name,
                'token' => $queries->token
            ]
        );
    }
}
 