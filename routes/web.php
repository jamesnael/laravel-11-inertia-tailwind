<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\HomeController;
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

Route::get('/', [HomeController::class, 'index']);

Route::get('lupa-password', '\Laravel\Fortify\Http\Controllers\PasswordResetLinkController@create')->name('password.request');
Route::post('lupa-password', '\Laravel\Fortify\Http\Controllers\PasswordResetLinkController@store')->name('password.email');

Route::get('reset-password/{token}', '\Laravel\Fortify\Http\Controllers\NewPasswordController@create')->name('password.reset');
Route::post('reset-password', '\Laravel\Fortify\Http\Controllers\NewPasswordController@store')->name('password.update');

Route::get('logout', function () {
    \Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/backend-login', [AuthenticatedSessionController::class, 'create'])
->middleware(['guest:'.config('fortify.guard')])
->name('login');

$limiter = config('fortify.limiters.login');
Route::post('/backend-login', [AuthenticatedSessionController::class, 'store'])
->middleware(array_filter([
    'guest:'.config('fortify.guard'),
    $limiter ? 'throttle:'.$limiter : null,
]));

Route::group(['as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

    Route::group(['prefix' => 'user', 'as' => 'profile.', 'namespace' => 'UserProfile'], function () {
        Route::get('profile', 'ProfileController@show')->name('show');
        Route::match(['put', 'patch'], 'profile', '\Laravel\Fortify\Http\Controllers\ProfileInformationController@update')->name('update');

        Route::get('password', 'PasswordController@show')->name('password');
        Route::match(['put', 'patch'], 'password', '\Laravel\Fortify\Http\Controllers\PasswordController@update')->name('password-update');
    });

    Route::get('log-activity', 'LogActivityController@index')->name('log-activity.index')->middleware('has_access:module.log-activity.index');
    Route::get('log-activity/{log_activity:id}/detail', 'LogActivityController@detail')->name('log-activity.detail')->middleware('has_access:module.log-activity.detail');
    Route::get('getLogAktivitasTable', 'LogActivityController@table')->name('log-activity.table')->middleware('has_access:module.log-activity.index');

    Route::group(['prefix' => 'data-master', 'as' => 'data-master.', 'namespace' => 'DataMaster'], function () {
        // Privacy Policy
        Route::group(['prefix' => 'privacy-policy', 'as' => 'privacy-policy.'], function () {
            Route::get('/', 'PrivacyPolicyController@index')->name('index')->middleware('has_access:module.data-master.privacy-policy.index');

            Route::get('/{privacy_policy}/edit', 'PrivacyPolicyController@edit')->name('edit')->middleware('has_access:module.data-master.privacy-policy.edit');
            Route::match(['put', 'patch'], '/{privacy_policy}', 'PrivacyPolicyController@update')->name('update')->middleware('has_access:module.data-master.privacy-policy.edit');
        });
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.', 'namespace' => 'Settings'], function () {
        Route::group(['prefix' => 'jabatan', 'as' => 'jabatan.'], function () {
            Route::get('/', 'JabatanController@index')->name('index')->middleware('has_access:module.settings.jabatan.index');
            Route::get('/create', 'JabatanController@create')->name('create')->middleware('has_access:module.settings.jabatan.create');
            Route::post('/', 'JabatanController@store')->name('store')->middleware('has_access:module.settings.jabatan.create');
            Route::get('/{jabatan:slug}/edit', 'JabatanController@edit')->name('edit')->middleware('has_access:module.settings.jabatan.edit');
            Route::match(['put', 'patch'], '/{jabatan:slug}', 'JabatanController@update')->name('update')->middleware('has_access:module.settings.jabatan.edit');
            Route::delete('/{jabatan:slug}', 'JabatanController@destroy')->name('destroy')->middleware('has_access:module.settings.jabatan.delete');
            Route::get('/table', 'JabatanController@table')->name('table')->middleware('has_access:module.settings.jabatan.index');
        });

        Route::group(['prefix' => 'karyawan', 'as' => 'karyawan.'], function () {
            Route::get('/', 'KaryawanController@index')->name('index')->middleware('has_access:module.settings.karyawan.index');
            Route::get('/create', 'KaryawanController@create')->name('create')->middleware('has_access:module.settings.karyawan.create');
            Route::post('/', 'KaryawanController@store')->name('store')->middleware('has_access:module.settings.karyawan.create');
            Route::get('/{karyawan:slug}/edit', 'KaryawanController@edit')->name('edit')->middleware('has_access:module.settings.karyawan.edit');
            Route::match(['put', 'patch'], '/{karyawan:slug}', 'KaryawanController@update')->name('update')->middleware('has_access:module.settings.karyawan.edit');
            Route::delete('/{karyawan:slug}', 'KaryawanController@destroy')->name('destroy')->middleware('has_access:module.settings.karyawan.delete');
            Route::get('/table', 'KaryawanController@table')->name('table')->middleware('has_access:module.settings.karyawan.index');
        });

        // Meta
        Route::group(['prefix' => 'meta', 'as' => 'meta.'], function () {
            Route::get('/', 'MetaController@index')->name('index')->middleware('has_access:module.settings.meta-tag.index');
            Route::get('/create', 'MetaController@create')->name('create')->middleware('has_access:module.settings.meta-tag.create');
            Route::post('/', 'MetaController@store')->name('store')->middleware('has_access:module.settings.meta-tag.create');

            Route::get('/{meta:slug}/edit', 'MetaController@edit')->name('edit')->middleware('has_access:module.settings.meta-tag.edit');
            Route::match(['put', 'patch'], '/{meta:slug}', 'MetaController@update')->name('update')->middleware('has_access:module.settings.meta-tag.edit');
            Route::delete('/{meta:slug}', 'MetaController@destroy')->name('destroy')->middleware('has_access:module.settings.meta-tag.delete');
            Route::get('/table', 'MetaController@table')->name('table')->middleware('has_access:module.settings.meta-tag.index');
        });
    });

    Route::group(['prefix' => 'about-us', 'as' => 'about-us.', 'namespace' => 'AboutUs'], function () {
        Route::group(['prefix' => 'history', 'as' => 'history.'], function () {
            Route::get('/', 'HistoryController@index')->name('index')->middleware('has_access:module.about-us.history.index');
            Route::get('/create', 'HistoryController@create')->name('create')->middleware('has_access:module.about-us.history.create');
            Route::post('/', 'HistoryController@store')->name('store')->middleware('has_access:module.about-us.history.create');

            Route::delete('/{history:slug}', 'HistoryController@destroy')->name('destroy')->middleware('has_access:module.about-us.history.delete');
            Route::get('/{history}/edit', 'HistoryController@edit')->name('edit')->middleware('has_access:module.about-us.history.edit');
            Route::match(['put', 'patch'], '/{history}', 'HistoryController@update')->name('update')->middleware('has_access:module.about-us.history.edit');

            Route::get('/table', 'HistoryController@table')->name('table')->middleware('has_access:module.about-us.history.index');
        });
    });

    Route::group(['prefix' => 'homepage', 'as' => 'homepage.', 'namespace' => 'Homepage'], function () {
        Route::group(['prefix' => 'banner', 'as' => 'sliding-banner.'], function () {
            Route::get('/', 'SlidingBannerController@index')->name('index')->middleware('has_access:module.homepage.sliding-banner.index');
    
            Route::get('/{banner:slug}/edit', 'SlidingBannerController@edit')->name('edit')->middleware('has_access:module.homepage.sliding-banner.edit');
            Route::match(['put', 'patch'], '/{banner:slug}', 'SlidingBannerController@update')->name('update')->middleware('has_access:module.homepage.sliding-banner.edit');
    
            Route::delete('/{banner:slug}', 'SlidingBannerController@destroy')->name('destroy')->middleware('has_access:module.homepage.sliding-banner.delete');
            Route::get('/table', 'SlidingBannerController@table')->name('table')->middleware('has_access:module.homepage.sliding-banner.index');
    
            Route::get('/create', 'SlidingBannerController@create')->name('create')->middleware('has_access:module.homepage.sliding-banner.create');
            Route::post('/', 'SlidingBannerController@store')->name('store')->middleware('has_access:module.homepage.sliding-banner.create');

            Route::get('/position', 'SlidingBannerController@position')->name('position')->middleware('has_access:module.homepage.sliding-banner.edit');
            Route::post('/store-position', 'SlidingBannerController@store_position')->name('store-position')->middleware('has_access:module.homepage.sliding-banner.edit');
        });

        // Supported By
        // Route::group(['prefix' => 'supported-by', 'as' => 'supported-by.'], function () {
        //     Route::get('/', 'SupportedByController@index')->name('index')->middleware('has_access:module.homepage.supported-by.index');
        //     Route::get('/create', 'SupportedByController@create')->name('create')->middleware('has_access:module.homepage.supported-by.create');
        //     Route::post('/', 'SupportedByController@store')->name('store')->middleware('has_access:module.homepage.supported-by.create');

        //     Route::get('/{supported_by:slug}/edit', 'SupportedByController@edit')->name('edit')->middleware('has_access:module.homepage.supported-by.edit');
        //     Route::match(['put', 'patch'], '/{supported_by:slug}', 'SupportedByController@update')->name('update')->middleware('has_access:module.homepage.supported-by.edit');
        //     Route::delete('/{supported_by:slug}', 'SupportedByController@destroy')->name('destroy')->middleware('has_access:module.homepage.supported-by.delete');
        //     Route::get('/table', 'SupportedByController@table')->name('table')->middleware('has_access:module.homepage.supported-by.index');
        // });

        //Home About
        Route::group(['prefix' => 'home-about', 'as' => 'home-about.'], function () {
            Route::get('/', 'HomeAboutController@index')->name('index')->middleware('has_access:module.homepage.home-about.index');

            Route::get('/{home_about}/edit', 'HomeAboutController@edit')->name('edit')->middleware('has_access:module.homepage.home-about.edit');
            Route::match(['put', 'patch'], '/{home_about}', 'HomeAboutController@update')->name('update')->middleware('has_access:module.homepage.home-about.edit');
        });
    });

    // Privacy Policy
    Route::group(['prefix' => 'settings/privacy-policy', 'as' => 'privacy-policy.'], function () {
        Route::get('/', 'PrivacyPolicyController@index')->name('index')->middleware('has_access:module.privacy-policy.index');

        Route::get('/{policy}/edit', 'PrivacyPolicyController@edit')->name('edit')->middleware('has_access:module.privacy-policy.edit');
        Route::match(['put', 'patch'], '/{policy}', 'PrivacyPolicyController@update')->name('update')->middleware('has_access:module.privacy-policy.edit');
        Route::post('/', 'PrivacyPolicyController@store')->name('store')->middleware('has_access:module.privacy-policy.index');
        Route::get('/create', 'PrivacyPolicyController@create')->name('create')->middleware('has_access:module.privacy-policy.create');


        Route::get('/page-setting/{page}', 'PrivacyPolicyController@page_setting')->name('page-setting')->middleware('has_access:module.privacy-policy.edit');
        Route::put('/store-page-setting/{page}', 'PrivacyPolicyController@store_page_setting')->name('store-page-setting')->middleware('has_access:module.privacy-policy.edit');
    });
});

// Upload image from text editor
Route::post('/store-image', 'TextEditorImageController@storeImage')->name('text-editor.store-image')->middleware(['auth:sanctum', 'verified']);