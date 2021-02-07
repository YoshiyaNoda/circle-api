<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OAuthTestController extends Controller
{
    public function retTargetUrl($provider) {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }
    public function handleProviderCallback($provider) {
        $providerUser = Socialite::with($provider)->stateless()->user(); // Laravel\Socialite\Two\InvalidStateException のエラーを解決するためにはこうしないといけないらしい

        try {

            $queries = [
                'token' => $providerUser->token,
                'status' => 'success',
                'email' => $providerUser->getEmail() ?? '',
                'name' => $providerUser->getName() ?? ''
            ];

            $queryString = http_build_query($queries, null, '&');

            return redirect(config('const_env.FRONT_URL')."/auth/finished?".$queryString);
        } catch(\Exception $e) {
            return redirect('/');
        }
    }
}
