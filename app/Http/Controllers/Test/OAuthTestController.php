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
        // $providerUser = Socialite::with($provider)->user();
        $providerUser = Socialite::with($provider)->stateless()->user(); // Laravel\Socialite\Two\InvalidStateException のエラーを解決するためにはこうしないといけないらしい

        try {
            $email = $providerUser->getEmail() ?? null;
            $providerId = $providerUser->getId();

            return redirect("http://localhost:8080/#".$providerUser->token);
        } catch(\Exception $e) {
            return redirect('/');
        }
    }
}
