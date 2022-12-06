<?php

use Illuminate\Support\Facades\Route;

/*
|-------------------------------
| Marketplace Routes
|-------------------------------
*/
Route::group([
    //'domain' => 'pubrecruiter.com',
    'namespace' => 'Marketplace',
], function() {
    //Homepage Route
    Route::get('/'                              , 'HomeController@index')->name('home')->middleware('noti');

    Route::group([
        'middleware' => ['auth'],
    ], function() {
        Route::group([
            'middleware' => ['noti'],
        ], function() {
            Route::get('brands'                 , 'HomeController@brands')->name('brands');
            Route::get('creators'               , 'HomeController@creators')->name('creators');
        });
        Route::get('more-contacts'              , 'HomeController@moreContacts')->name('more-contacts');

        Route::post('favorite-brand'            , 'HomeController@favoriteBrand')->name('favorite-brand');
        Route::post('request-partnership'       , 'HomeController@requestPartnership')->name('request-partnership');
        Route::post('opportunities-inquiry'     , 'HomeController@opportunitiesInquiry')->name('opportunities-inquiry');
        Route::post('network-signup'            , 'HomeController@trackNetworkSignup')->name('network-signup');
    });

    //Account Route
    Route::group([
        'middleware' => ['guest'],
    ], function() {
        Route::get('login'                      , 'AuthController@login')->name('login');
        Route::post('login'                     , 'AuthController@postLogin');

        Route::get('create-profile'             , 'AuthController@createProfile')->name('create-profile');
        Route::get('join-as-brand'              , 'AuthController@joinAsBrand')->name('join-as-brand');
        Route::post('join-as-brand'             , 'AuthController@postAsBrand');
        Route::get('join-as-creator'            , 'AuthController@joinAsCreator')->name('join-as-creator');
        Route::post('join-as-creator'           , 'AuthController@postAsCreator');

        Route::get('forgot-password'            , 'AuthController@forgot')->name('forgot-password');
        Route::post('forgot-password'           , 'AuthController@postForgot');

        Route::get('reset-password/{token}'     , 'AuthController@reset')->name('reset-password');
        Route::post('reset-password/{token}'    , 'AuthController@postReset');
    });

    Route::group([
        'middleware' => ['auth'],
    ], function() {
        Route::get('get-noti'                   , 'DashboardController@getNoti')->name('get-noti');
        Route::post('partnership-seen'          , 'DashboardController@seen')->name('partnership-seen');

        Route::group([
            'middleware' => ['noti'],
        ], function() {
            Route::get('dashboard'              , 'DashboardController@index')->name('dashboard');

            Route::get('outbound'               , 'DashboardController@outbound')->name('outbound');
            Route::post('outbound'              , 'DashboardController@updateOutbound');

            Route::get('opportunities'          , 'DashboardController@opportunities')->name('opportunities');
            Route::post('opportunities'         , 'DashboardController@storeOpportunity')->name('opportunities.store');
            Route::put('opportunities/{id}'     , 'DashboardController@updateOpportunity')->name('opportunities.update');
            Route::delete('opportunities/{id}'  , 'DashboardController@destroyOpportunity')->name('opportunities.destroy');

            Route::post('media-kit'             , 'DashboardController@storeMediaKit')->name('media-kit.store');
            Route::delete('media-kit'           , 'DashboardController@destroyMediaKit')->name('media-kit.destroy');

            Route::get('favorites'              , 'DashboardController@favorites')->name('favorites');
            Route::delete('remove-favorite'     , 'DashboardController@removeFavorite')->name('remove-favorite');

            Route::get('setting'                , 'DashboardController@setting')->name('setting');
            Route::put('setting'                , 'DashboardController@updateSetting');
        });

        Route::get('logout', function() {
            auth()->logout();
            return redirect('/');
        })->name('logout');
    });
});

/*
|-------------------------------
| Admin Routes
|-------------------------------
*/
Route::group([
    //'domain' => 'extension.pubrecruiter.com',
], function() {
    /*Route::get('/', function() {
        return redirect()->route('admin');
    });*/
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin',
    ], function() {
        Route::group([
            'middleware' => 'guest:admin',
        ], function() {
            Route::get('login'                  , 'AuthController@login')->name('admin.login');
            Route::post('login'                 , 'AuthController@postLogin');

            Route::get('forgot-password'        , 'AuthController@forgot')->name('admin.forgot-password');
            Route::post('forgot-password'       , 'AuthController@postForgot');

            Route::get('reset-password/{token}' , 'AuthController@reset')->name('admin.reset-password');
            Route::post('reset-password/{token}', 'AuthController@postReset');
        });

        Route::group([
            'middleware' => 'auth:admin',
        ], function() {
            Route::get('/', function() {
                return redirect()->route('admin.users.index');
            })->name('admin');

            /*
            Route::get('approval'                   , 'ApprovalController@index')->name('admin.approval');
            Route::get('approval/{id}'              , 'ApprovalController@edit')->name('admin.approval.edit');
            Route::put('approval/{id}'              , 'ApprovalController@update')->name('admin.approval.update');
            Route::delete('approval/{id}'           , 'ApprovalController@block')->name('admin.approval.block');
            */

            Route::resources([
                'users'         => 'UsersController',
                'contacts'      => 'ContactsController',
                'metrics'       => 'MetricsController',
                'blacklists'    => 'BlacklistsController',
                'feedback'      => 'FeedbackController',
                'outreach'      => 'OutreachController',
                'flag'          => 'FlagController',
                'commissions'   => 'CommissionsController',
                'opportunities' => 'OpportunityController',
                'networks'      => 'NetworksController',
                'sub'           => 'SubController',
                'referrals'     => 'ReferralsController',
                'ads'           => 'AdsController',
            ], [
                'as' => 'admin'
            ]);
            Route::post('ads/disable'           , 'AdsController@disableADS')->name('admin.ads.disable');

            Route::get('settings'               , 'HomeController@settings')->name('admin.settings');
            Route::post('settings'              , 'HomeController@updateSettings');

            Route::get('profile'                , 'HomeController@profile')->name('admin.profile');
            Route::post('profile/email'         , 'HomeController@updateProfileEmail')->name('admin.update-profile-email');
            Route::post('profile/password'      , 'HomeController@updateProfilePassword')->name('admin.update-profile-password');

            Route::get('logout', function() {
                auth('admin')->logout();
                return redirect()->route('admin.login');
            })->name('admin.logout');
        });
    });
});
