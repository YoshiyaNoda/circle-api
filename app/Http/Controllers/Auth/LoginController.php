<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
//use Laravel\Socialite\Facades\Socialite;
use Socialite;
use Auth;
//use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    
    public function retTargetUrl($provider) {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }
    public function handleProviderCallback($provider) {
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
           
           
            //$request->session()->put('user_token',$providerUser->token);
            // DB::table('sessions')
            // ->where('id',  $id )
            // ->update(['user_id' => 2]);
            //config('const_env.FRONT_URL')."/auth/finished?".$queryString



            return redirect(config('const_env.FRONT_URL')."/auth/finished?".$queryStrig);
        } catch(\Exception $e) {
            return redirect(config('const_env.FRONT_URL')."/auth/failed");
        }
    }
}
