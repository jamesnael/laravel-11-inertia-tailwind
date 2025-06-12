<?php

use App\Models\MetaTag;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '/'], function () {
    Route::group(['as' => 'frontend.', 'namespace' => 'Frontend'], function () {
        /*---------------------------------- Home ---------------------------------------*/
        Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
            Route::get('/verify', 'HomeController@verify')->name('verify');
        });
        /*---------------------------------- Home ---------------------------------------*/

        if (Schema::hasTable('tb_meta_tag')) {
            $meta = MetaTag::get();

            foreach($meta as $value){
                if ($value['slug'] == 'homepage') {
                    Route::group(['prefix' => '', 'as' => 'home.'], function () use($value) {
                        Route::get('/'.$value['route_slug'], $value['controller_name'].'@index')->name('index');
                    });
                }
            }
        }

    });
});
