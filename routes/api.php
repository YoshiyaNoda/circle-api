<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api', 'session'])->group(function() {
    $testPath = "\App\Http\Controllers\Test";
    Route::get('fetch/{provider}/oauth-target-url-test', $testPath.'\OAuthTestController@retTargetUrl');
    Route::get('auth/{provider}/callback', $testPath.'\OAuthTestController@handleProviderCallback');
});
