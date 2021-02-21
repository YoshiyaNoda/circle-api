<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class OAuthController extends Controller
{
    public function retTargetUrl($provider) {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
        
    }
    public function handleProviderCallback($provider,Request $request) {
        $providerUser = Socialite::with($provider)->stateless()->user(); // Laravel\Socialite\Two\InvalidStateException のエラーを解決するためにはこうしないといけないらしい

        try {

            $queries = [
                'token' => $providerUser->token,
                'email' => $providerUser->getEmail() ?? '',
                'name' => $providerUser->getName() ?? '',
                'provider' => $provider
            ];
            User::createOrUpdateOnCallback($queries);

            $responsequeries = [
                'login' => true,//フロントにトークンは渡さないかわりに、ログインできたという情報を送る
                'email' => $providerUser->getEmail() ?? '',
                'name' => $providerUser->getName() ?? '',
            ];

            $queryString = http_build_query($responsequeries, null, '&');

            $request->session()->put('user_token',$providerUser->token);

            return redirect(config('const_env.FRONT_URL')."/auth/finished?".$queryString);
        } catch(\Exception $e) {
            return redirect(config('const_env.FRONT_URL')."/auth/failed");
        }
    }
}
