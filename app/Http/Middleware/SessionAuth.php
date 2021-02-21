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
        $token = $request->session()->get('user_token');
        $user = User::where('token', $token)->first();
        if($user) {
            $request->token = $token;
            return $next($request);
        } else {
            return abort(401, 'セッション認証できませんでした');
            //return redirect(config('const_env.FRONT_URL')."/login");
        }
        
    }
}