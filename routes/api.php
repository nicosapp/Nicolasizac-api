<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes([
  'register' => false,
  'verify' => true,
  'reset' => true
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return new UserResource($request->user());
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
  Route::post('signup', 'SignUpController');
  Route::get('signin/{service}', 'SocialLoginController@redirect');
  Route::get('signin/{service}/callback', 'SocialLoginController@callback');
});


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'users', 'namespace' => 'Users'], function () {
  Route::get('{user}', 'UserController@show');
  Route::patch('{user}', 'UserController@update');
  Route::patch('{user}/profile', 'UserController@updateProfile');
  Route::patch('{user}/password', 'UserController@updatePassword');
  Route::post('{user}/avatar', 'UserController@avatar');
});

Route::group(['middleware' => 'guest', 'prefix' => 'contact', 'namespace' => 'Contact'], function () {
  Route::post('me', 'ContactController@contactMe');
});

Route::group(['prefix' => 'media', 'namespace' => 'Media'], function () {
  Route::get('config', 'MediaConfigController@index');
});
