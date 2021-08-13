<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Here is where you can register guest routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "public" middleware group. Now create something great!
|
*/

// Api routes without authentication
Route::group([
    'prefix' => 'api/v2',
    'middleware' => ['public'],
    'namespace' => 'Bachelor\Port\Primary\WebApi\Controllers\Api'
], function () {

    // Ping
    Route::get('ping', function () {
        return response('pong', 200);
    });

    // Authentication Routes
    Route::post('send-verification-code', 'SmsController@sendVerificationCode')->name('send-verification-code');
    Route::post('verify-code', 'SmsController@verifyCode')->name('verify-code');
    Route::post('social-login', 'AuthenticationController@socialLogin')->name('social-login');

    // Stripe Webhooks
    // Admin routes without authentication
    Route::prefix('webhook')->group(function () {
        Route::post('stripe', 'StripeWebhookController@webhook');
    });

    // Notification
    Route::prefix('notification')->group(function () {
        Route::get('notification-email-message/mark-as-read', 'NotificationController@markEmailNotificationAsRead')
            ->name('notification-email-history.verify');
    });

    //get current server time
    Route::get('current-server-time', 'UserController@getCurrentServerTime');

    Route::prefix('user')->group(function () {
        // Match info
        Route::get('match-info', 'MatchInfoController@filterGroupByAgeAndGender');
    });
});

// Api routes with session
Route::group([
    'prefix' => 'api/v2',
    'middleware' => ['web'],
    'namespace' => 'Bachelor\Port\Primary\WebApi\Controllers\Api'
], function () {

    // Authentication Routes
    Route::get('auth/login/facebook', 'AuthenticationController@redirectToFacebookProvider')->name('auth-login-fb');
    Route::get('facebook/callback', 'AuthenticationController@handleFacebookProviderCallback')->name('facebook-callback');
    Route::get('auth/login/line', 'AuthenticationController@redirectToLineProvider')->name('auth-login-line');
    Route::get('line/callback', 'AuthenticationController@handleLineProviderCallback')->name('line-callback');
});

// Base routes without authentication
Route::group([
    'middleware' => ['public'],
    'namespace' => 'Bachelor\Port\Primary\WebApi\Controllers\Admin'
], function () {

    // Default landing page
    Route::get('/', function () {
        return view('welcome');
    });

    // Ping
    Route::get('ping', function () {
        return response('pong', 200);
    });
});

// Admin routes without authentication
Route::group([
    'prefix' => 'admin',
    'middleware' => ['public'],
    'namespace' => 'Bachelor\Port\Primary\WebApi\Controllers\Admin'
], function () {

    // Default landing page
    Route::get('/', function () {
        return view('welcome');
    });

    // Ping
    Route::get('ping', function () {
        return response('pong', 200);
    });
});
