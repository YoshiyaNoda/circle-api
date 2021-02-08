<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class OAuthController extends Controller
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
                'name' => $providerUser->getName() ?? ''
            ];

            $queryString = http_build_query($queries, null, '&');

            User::createOrUpdateOnCallback($queries);

            return redirect(config('const_env.FRONT_URL')."/auth/finished?".$queryString);
        } catch(\Exception $e) {
            return redirect(config('const_env.FRONT_URL')."/auth");
        }
    }
}
