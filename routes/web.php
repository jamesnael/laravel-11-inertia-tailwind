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

Route::get('lupa-password', '\Laravel\Fortify\Http\Controllers\PasswordResetLinkController@create')->name('password.request');
Route::post('lupa-password', '\Laravel\Fortify\Http\Controllers\PasswordResetLinkController@store')->name('password.email');

Route::get('reset-password/{token}', '\Laravel\Fortify\Http\Controllers\NewPasswordController@create')->name('password.reset');
Route::post('reset-password', '\Laravel\Fortify\Http\Controllers\NewPasswordController@store')->name('password.update');

Route::get('logout', function () {
  \Auth::logout();
  return redirect()->route('login');
})->name('logout');

Route::get('/adminpage', [AuthenticatedSessionController::class, 'create'])
  ->middleware(['guest:' . config('fortify.guard')])
  ->name('login');

$limiter = config('fortify.limiters.login');
Route::post('/adminpage', [AuthenticatedSessionController::class, 'store'])
  ->middleware(array_filter([
    'guest:' . config('fortify.guard'),
    $limiter ? 'throttle:' . $limiter : null,
  ]));

Route::group(['prefix' => 'backend', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth:sanctum', 'verified']], function () {
  Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
  Route::get('/dashboard-chart', 'DashboardController@getChartData')->name('dashboard.chart');

  // Province
  Route::get('/get-data-city', 'ProvinceController@city')->name('province.city');
  Route::get('/get-data-district', 'ProvinceController@district')->name('province.district');
  Route::get('/get-data-subdistrict', 'ProvinceController@subdistrict')->name('province.subdistrict');

  // Profile
  Route::group(['prefix' => 'user', 'as' => 'profile.', 'namespace' => 'UserProfile'], function () {
    Route::get('profile', 'ProfileController@show')->name('show');
    Route::match(['put', 'patch'], 'profile', '\Laravel\Fortify\Http\Controllers\ProfileInformationController@update')->name('update');

    Route::get('password', 'PasswordController@show')->name('password');
    Route::match(['put', 'patch'], 'password', '\Laravel\Fortify\Http\Controllers\PasswordController@update')->name('password-update');
  });

  // Log Activity
  Route::get('log-activity', 'LogActivityController@index')->name('log-activity.index')->middleware('has_access:module.log-activity.index');
  Route::get('log-activity/{log_activity:id}/detail', 'LogActivityController@detail')->name('log-activity.detail')->middleware('has_access:module.log-activity.detail');
  Route::get('getLogAktivitasTable', 'LogActivityController@table')->name('log-activity.table')->middleware('has_access:module.log-activity.index');

  // Data Master
  Route::group(['prefix' => 'data-master', 'as' => 'data-master.', 'namespace' => 'DataMaster'], function () {
    // Role
    Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
      Route::get('/', 'RoleController@index')->name('index')->middleware('has_access:module.data-master.role.index');
      Route::get('/create', 'RoleController@create')->name('create')->middleware('has_access:module.data-master.role.create');
      Route::post('/', 'RoleController@store')->name('store')->middleware('has_access:module.data-master.role.create');
      Route::get('/{role:slug}/edit', 'RoleController@edit')->name('edit')->middleware('has_access:module.data-master.role.edit');
      Route::match(['put', 'patch'], '/{role:slug}', 'RoleController@update')->name('update')->middleware('has_access:module.data-master.role.edit');
      Route::delete('/{role:slug}', 'RoleController@destroy')->name('destroy')->middleware('has_access:module.data-master.role.delete');
      Route::get('/table', 'RoleController@table')->name('table')->middleware('has_access:module.data-master.role.index');
    });

    // User
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
      Route::get('/', 'UserController@index')->name('index')->middleware('has_access:module.data-master.user.index');
      Route::get('/create', 'UserController@create')->name('create')->middleware('has_access:module.data-master.user.create');
      Route::post('/', 'UserController@store')->name('store')->middleware('has_access:module.data-master.user.create');
      Route::get('/{user:slug}/edit', 'UserController@edit')->name('edit')->middleware('has_access:module.data-master.user.edit');
      Route::match(['put', 'patch'], '/{user:slug}', 'UserController@update')->name('update')->middleware('has_access:module.data-master.user.edit');
      Route::delete('/{user:slug}', 'UserController@destroy')->name('destroy')->middleware('has_access:module.data-master.user.delete');
      Route::get('/table', 'UserController@table')->name('table')->middleware('has_access:module.data-master.user.index');
      Route::get('/role', 'UserController@role')->name('role');
    });
  });
});

// Upload image from text editor
Route::post('/store-image', 'TextEditorImageController@storeImage')->name('text-editor.store-image')->middleware(['auth:sanctum', 'verified']);
