<?php

use Illuminate\Http\Request;
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

Route::group([
    //'domain' => 'extension.pubrecruiter.com',
    'namespace' => 'API',
], function() {
    Route::group([
    ], function() {
        Route::post('login'     , 'AuthController@login');
        //Route::post('register'  , 'AuthController@register');
    });

    Route::group([
        'middleware' => ['auth:sanctum', 'active'],
    ], function() {
        Route::get('contact'                , 'HomeController@contact');
        Route::get('notifications'          , 'HomeController@notifications');

        Route::post('no-contact-found'      , 'HomeController@noContactFound');

        Route::post('add-favorite'          , 'HomeController@addFavorite');

        Route::post('partnership-inquiry'   , 'HomeController@sendPartnershipInquiry');
        Route::post('opportunities-inquiry' , 'HomeController@sendOpportunitiesInquiry');

        Route::post('feedback'              , 'HomeController@saveFeedback');

        Route::post('update-password'       , 'HomeController@updatePassword');
        Route::post('request-publisher'     , 'HomeController@requestPublisher');

        Route::get('clear-noti'             , 'HomeController@clearNoti');
    });
});
