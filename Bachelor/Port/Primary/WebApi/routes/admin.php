<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group([
    'middleware' => [ 'admin' ],
    'namespace' => 'Bachelor\Port\Primary\WebApi\Controllers\Admin'
], function () {

    // Users
    Route::prefix('user')->group(function () {
        Route::get('list', 'UserController@listUsers');
        Route::get('view-profile/{userId}', 'UserController@viewProfile');
        Route::post('update-status', 'UserController@updateStatus');
        Route::post('fake', 'UserController@fakeUser');
        Route::post('upload-bulk-approval-csv', 'UserController@uploadBulkApprovalCsv');
    });

    // Coupon
    Route::prefix('coupon')->group(function () {
        Route::post('issue', 'CouponController@issueCoupon');
    });

    // Participants
    Route::prefix('participant')->group(function () {
        Route::get('list', 'ParticipantController@getParticipants');
        Route::post('migrate-main-matching', 'ParticipantController@migrateMainMatchingParticipants');
        Route::get('reset-dating-and-participation', 'ParticipantController@resetDatingAndParticipant');

        Route::get('recommendation/list', 'ParticipantRecommendationSettingController@getRecommendations');
        Route::post('recommendation/set', 'ParticipantRecommendationSettingController@setRecommendations');
        Route::get('awaiting-cancel/list', 'ParticipantAwaitingCancelSettingController@getAwatingCancels');
        Route::post('awaiting-cancel/set', 'ParticipantAwaitingCancelSettingController@setAwaitingCancels');
    });

    // matching
    Route::prefix('matching-date')->group(function () {
        Route::get('list', 'DatingController@getMatchingDateSetting');
    });

    // Dating
    Route::prefix('dating')->group(function () {
        Route::post('rematch', 'DatingController@rematch');
    });


    // Dating day
    Route::prefix('dating-days')->group(function () {
        Route::get('/', 'DatingController@getDatingDay');
    });

    //dating days of week
    Route::prefix('dating-days-of-week-setting')->group(function () {
        Route::get('/', 'DatingController@getDatingDayOfWeekSetting');
        Route::post('migrate-data', 'DatingController@createOrUpdateDatingDayOfWeekSetting');
    });

    //gender ratio
    Route::prefix('gender-ratio')->group(function () {
        Route::get('/', 'ParticipantAwaitingCountSettingController@handle');
        Route::post('/update', 'ParticipantAwaitingCountSettingController@update');
    });

    // Prefecture
    Route::prefix('prefectures')->group(function () {
        Route::get('/', 'PrefectureController@handle');
        Route::post('create', 'PrefectureController@create');
        Route::post('update/{id}', 'PrefectureController@update');
        Route::post('delete/{id}', 'PrefectureController@delete');
    });


    // matched user pair list
    Route::prefix('match-pair-list')->group(function () {
        Route::get('/', 'DatingController@getDatingHistory');
        Route::post('create', 'DatingController@createMatchedPairList');
        Route::get('update/{id}', 'DatingController@getUpdateMatchedPairList');
        Route::post('update/{id}', 'DatingController@updateMatchedPairList');
        Route::post('cancel/{id}', 'DatingController@cancelMatchedPairList');
    });

    // Area
    Route::prefix('areas')->group(function () {
        Route::get('/', 'AreaController@handle');
        Route::post('create', 'AreaController@create');
        Route::post('update/{id}', 'AreaController@update');
        Route::post('delete/{id}', 'AreaController@delete');
    });

    // Dating Places
    Route::prefix('dating-places')->group(function () {
        Route::get('/', 'DatingPlaceController@handle');
        Route::post('create', 'DatingPlaceController@create');
        Route::post('update/{id}', 'DatingPlaceController@update');
        Route::post('delete/{id}', 'DatingPlaceController@delete');
        Route::post('change-approve/{id}', 'DatingPlaceController@approveOrDisapproveDatingPlace');
    });

    // user preferred Areas
    Route::prefix('user-preferred-laces')->group(function () {
        Route::get('/', 'UserController@getUserPreferredPlaces');
    });

    // Admin Notification Module
    Route::prefix('notification')->group(function () {
        Route::get('/', 'NotificationController@index');
        Route::post('update/{id}', 'NotificationController@update');
        Route::post('read/{id}', 'NotificationController@read');
        Route::post('send-bulk-message', 'NotificationController@sendBulkMessage');
    });

    // Match info Setting
    Route::prefix('match-info')->group(function () {
        Route::get('/', 'MatchInfoController@getAllInfos');
        Route::post('/', 'MatchInfoController@createGroupAndInfo');
        Route::post('/{id}', 'MatchInfoController@updateInfo')->where('id',  '[0-9]+');
        Route::delete('/group/{id}', 'MatchInfoController@deleteGroup')->where('id',  '[0-9]+');
    });

    // School Management
    Route::prefix('school')->group(function () {
        Route::get('/', 'SchoolController@getAllSchools');
        Route::post('/', 'SchoolController@createSchool');
        Route::put('/{id}', 'SchoolController@updateSchool')->where('id',  '[0-9]+');
        Route::delete('/{id}', 'SchoolController@deleteSchool')->where('id',  '[0-9]+');
    });

    // Delete user coupon
    //Route::post('coupon/delete/{userId}', 'UserCouponController@deleteUserCoupon');
    // Time settings
    Route::prefix('time-settings')->group(function () {
        Route::get('/', 'TimeSettingsController@getTimings');
        Route::post('/', 'TimeSettingsController@updateTimings');
    });
    Route::prefix('chat')->group(function () {
        Route::get('/rooms', 'ChatController@getRooms');
        Route::get('/room/{id}', 'ChatController@getRoomDetail');
        Route::get('/messages', 'ChatController@getMessages');
    });

    //Train station
    Route::prefix('train-stations')->group(function () {
        Route::get('/', 'TrainStationController@getTrainStations');
    });

    //plan
    Route::prefix('plans')->group(function () {
        Route::get('/', 'PlanController@getAllPlans');
    });
});
