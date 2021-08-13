<?php

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


// Api routes with authentication
Route::group([
    'prefix' => 'v2',
    'middleware' => ['api'],
    'namespace' => 'Bachelor\Port\Primary\WebApi\Controllers\Api'
], function () {
    // User specific routes : /api/v2/
    Route::prefix('user')->group(function () {
        Route::get('/', 'UserController@index');
        // User Registration form routes : /api/v2/user/
        Route::get('registration/{step}', 'UserRegistrationController@index');
        Route::post('registration/{step}/store', 'UserRegistrationController@store');
        Route::post('store-image', 'UserRegistrationController@storeImage')->name('store-image');;

        // Migrate user account
        Route::post('migrate-account', 'MigrationController@migrateAccount')->name('migrate-account');

        // Used to logout user
        Route::get('logout', 'AuthenticationController@logout');

        // User Credit Card CRUD api
        Route::prefix('cards')->group(function () {
            Route::get('/', 'UserCardController@index');
            Route::post('store', 'UserCardController@store');
            Route::put('set-default/{cardId}', 'UserCardController@setDefaultPaymentCard')->name('user-cards.set-default');
            Route::delete('delete/{cardId}', 'UserCardController@delete');
        });

        // Match profile : api/v2/user/
        Route::get('match-profile', 'DatingController@getMatchProfile');
        Route::get('match-profile/{datingId}', 'DatingController@getMatchProfileDetail');

        // Change plan module : /api/v2/user/
        Route::prefix('plan')->group(function () {
            Route::get('/', 'PlanController@getPlan');
            Route::post('change/{id}', 'PlanController@changePlan');
        });

        // User coupon module : /api/v2/user/
        Route::prefix('coupon')->group(function () {
            // Get all user coupon data
            Route::get('/', 'UserCouponController@index');
            // Type can only be bachelor or dating
            Route::post('issue/{type}', 'UserCouponController@issueCoupon');
            // Type can only be bachelor or dating
            Route::post('purchase/{type}', 'UserCouponController@purchaseCoupon');
            // Return specific user coupon
            Route::post('{userCouponId}/return', 'UserCouponController@returnUserCoupon');
            // Type can only be bachelor or dating
            Route::post('apply/{type}', 'UserCouponController@applyUserCoupon');
            // Perform exchange of coupon
            Route::post('exchange/{type}', 'UserCouponController@exchangeUserCoupon');
            // Discard all the user coupon
            Route::post('discard', 'UserCouponController@discardUserCoupon');
        });

        // Change plan module : /api/v2/user/
        Route::prefix('status')->group(function () {
            Route::post('reactive-reapprove-request', 'UserController@requestToReactivateOrReapproved');
        });
        // Cancel account and deactivate account
        Route::post('cancel-account', 'UserAccountController@cancelAccount');
        Route::post('deactivate-account', 'UserAccountController@deactivateAccount');
        Route::get('validate-deactivate-cancel-account', 'UserAccountController@validateBeforeCancelDeactivateAccount');

        Route::get('get-mypage-info', 'UserController@getMypageInfo')->name('user.get-mypage-info');
        // Get Profile info: /api/v2/user/
        Route::get('get-profile-info', 'UserController@getProfileInfo')->name('user.get-profile-info');

        // Update Profile
        Route::post('update-profile', 'UserController@updateProfile')->name('user.update-profile');

        // Get Preference info: /api/v2/user/
        Route::get('get-preference-info', 'UserController@getPreferenceInfo')->name('user.get-preference-info');

        // Update Preference
        Route::post('update-preference', 'UserController@updatePreference')->name('user.update-preference');

        // Update Email
        Route::post('update-email', 'UserController@updateEmail')->name('user.update-email');
    });

    Route::prefix('feedback')->group(function () {
        Route::post('create', 'FeedbackController@store')->name('store-feedback');
        Route::get('need-send-feedback', 'FeedbackController@isNeedGiveFeedback');
        Route::get('get-feedback-info', 'FeedbackController@getInfoGenerateFeedback');
        Route::get('check-send-feedback', 'FeedbackController@checkSendFeedback');
    });

    // Participation
    Route::prefix('participation')->group(function () {
        Route::get('get-dating-days', 'ParticipantMainMatchController@getDatingDays');
        Route::get('get-awaiting-participant-datingDays', 'ParticipantMainMatchController@getAwaitingParticipantDatingDays');
        Route::post('request-participate', 'ParticipantMainMatchController@requestParticipateMainMatch');
        Route::post('cancel-participate', 'ParticipantMainMatchController@cancelParticipateMainMatch');
        Route::post('cancel-sample-participate', 'ParticipantMainMatchController@cancelSampleParticipateMainMatch');
        Route::post('cancel-participate-rematch', 'ParticipantForRematchController@cancelParticipateRematching');
        Route::post('request-participate-rematch', 'ParticipantForRematchController@requestParticipateRematching');
    });

    // Dating
    Route::prefix('dating')->group(function () {
        Route::post('cancel-date', 'DatingController@cancelDating');
        Route::post('cancelled-by-partner', 'DatingController@cancelledByPartner');
    });

    // Dating place

    Route::prefix('dating-place')->group(function () {
        Route::get('cafes-at-same-station', 'DatingPlaceController@getThreeCafesAtSameStation');
    });

    // Chat
    Route::prefix('chat')->group(function () {
        Route::get('generate-token', 'ChatController@getToken');
        Route::post('send-message', 'ChatController@sentMessage');
        Route::get('messages', 'ChatController@getMessage');
        Route::get('get-room', 'ChatController@getData');
        Route::get('get-chat-dating-day', 'ChatController@getDatingDayAbleToChat');
        Route::get('room/{id}', 'ChatController@getChatByRoomCode');
    });

    // Dating report
    Route::prefix('dating-report')->group(function () {
        Route::get('index', 'DatingReportController@index');
        Route::get('dating-report-info', 'DatingReportController@getDatingReportInfo');
    });
});
