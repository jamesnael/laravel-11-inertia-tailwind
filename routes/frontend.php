<?php

use App\Http\Controllers\Frontend\RencanaStrategisController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\InformasiPublikController;
use App\Http\Controllers\Frontend\KebijakanPrivasiController;
use App\Http\Controllers\Frontend\KontakController;
use App\Http\Controllers\Frontend\LayananController;
use App\Http\Controllers\Frontend\ProdukHukumController;
use App\Http\Controllers\Frontend\ProfilController;
use App\Http\Controllers\Frontend\PublikasiController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\UnitKerjaController;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

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
  });
});
