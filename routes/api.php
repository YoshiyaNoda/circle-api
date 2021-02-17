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
    Route::get('fetch/{provider}/oauth-target-url-test', 'OAuthController@retTargetUrl');
    Route::get('auth/{provider}/callback', 'OAuthController@handleProviderCallback');
});

Route::middleware(['api'])->group(function() {
    Route::post('fetch-article-list', 'ArticleController@fetchArticleList');
    Route::post('create-article', 'ArticleController@createArticle');
    Route::post('fetch-article-data', 'ArticleController@fetchArticleData');
    Route::post('save-article-data', 'ArticleController@saveArticleData');
    Route::post('fetch-raw-HTML', 'ArticleController@fetchRawHTML');
    Route::post('save-raw-HTMl', 'ArticleController@saveRawHTML');

    Route::post('upload-image', 'ImageController@uploadImage');
    Route::post('fetch-image-list', 'ImageController@retImagesAll');
});