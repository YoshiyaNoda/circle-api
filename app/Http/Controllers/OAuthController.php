<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
//use App\Models\Session;
use Illuminate\Support\Facades\DB;
//use Illuminate\Session\SessionManager


class OAuthController extends Controller
{
    
    public function retTargetUrl($provider) {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }
    public function handleProviderCallback($provider ,Request $request) {
        $providerUser = Socialite::with($provider)->stateless()->user(); // Laravel\Socialite\Two\InvalidStateException のエラーを解決するためにはこうしないといけないらしい

        try {

            $queries = [
                'token' => $providerUser->token,
                'email' => $providerUser->getEmail() ?? '',
                'name' => $providerUser->getName() ?? '',
                'provider' => $provider
            ];

            $queryString = http_build_query($queries, null, '&');
            
            User::createOrUpdateOnCallback($queries);
           
           
            $request->session()->put('user_token',$providerUser->token);
            



            return redirect(config('const_env.FRONT_URL')."/auth/finished?".$queryString);//?がクエリパラメータを渡すよ
        } catch(\Exception $e) {
            return redirect(config('const_env.FRONT_URL')."/auth/failed");
        }
    }
}
