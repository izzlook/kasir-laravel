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

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ProductController
// route menambah product atau makanan
Route::post('product/simpan-product', 'App\Http\Controllers\MenuController@store')->name('product.simpan-product');

// route menampilkan daftar product
Route::get('/products', 'App\Http\Controllers\MenuController@index')->name('products.index');

// Rute untuk menampilkan form edit produk
Route::get('/products/{product}/edit', 'App\Http\Controllers\MenuController@edit')->name('products.edit');

// Rute untuk mengupdate produk
Route::put('/products/{product}', 'App\Http\Controllers\MenuController@update')->name('products.update');

// Rute untuk menghapus produk
Route::delete('/products/{product}', 'App\Http\Controllers\MenuController@destroy')->name('products.destroy');

Route::post('/products/save-order', 'App\Http\Controllers\MenuController@order')->name('products.save-order');

// OrderController hapus semua
Route::get('/orders/destroyAll', 'App\Http\Controllers\OrderController@destroyAll')->name('orders.destroyAll');

//cetak
Route::get('/cetakBill', 'App\Http\Controllers\MenuController@cetakInvoice')->name('cetakBill');