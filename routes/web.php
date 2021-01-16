<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\FacebookSocialiteController;
use App\Http\Controllers\UserContentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('auth/facebook', [FacebookSocialiteController::class, 'redirectToFB']);
Route::get('auth/facebook/callback', [FacebookSocialiteController::class, 'handleCallback']);

Route::get('list', [UserContentController::class, 'list']);


// Route::get('auth/facebook', 'Auth\FacebookSocialiteController@redirectToFB');
// Route::get('callback/facebook', 'Auth\FacebookSocialiteController@handleCallback');

// Route::get('auth/login', 'Auth\SocialController@viewLogin');
// Route::get('auth/login/facebook', 'Auth\SocialController@redirectToFacebookProvider');
// Route::get('auth/facebook/callback', 'Auth\SocialController@handleFacebookProviderCallback');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
