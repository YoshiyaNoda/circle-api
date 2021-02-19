<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SessionAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $user = User::where('token', $request->token)->first();
        $token = $request->session()->get('user_token');
        $user = User::where('token', $token)->first();
        if($user->exists()) {
            return $next($request);
        } else {
             return redirect(config('const_env.FRONT_URL')."/auth/failed");
        }

        
    }
}
