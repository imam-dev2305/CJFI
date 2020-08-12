<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::middleware('auth')->group(function (){
    Route::prefix('inventory')->group(function (){
        Route::prefix('mutasi')->group(function (){
            Route::get('/', 'Inventory\MutasiController@index');
            Route::get('/add', 'Inventory\MutasiController@create')->name('inventory.mutasi.add');
            Route::post('/store', 'Inventory\MutasiController@store')->name('inventory.mutasi.store');
            Route::get('/data', 'Inventory\MutasiController@show')->name('inventory.mutasi.data');
        });
        Route::prefix('barang')->group(function (){
            Route::post('/stok', 'Inventory\BarangController@stok')->name('inventory.barang.stok');
        });
    });
});
