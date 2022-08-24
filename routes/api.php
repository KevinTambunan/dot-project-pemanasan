<?php

use App\Http\Controllers\Api\PembelianController;
use App\Http\Controllers\Api\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
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

// produk
Route::get('/produk', [ProdukController::class, 'produk']);
Route::get('/deleteProduk/{id}', [ProdukController::class, 'deleteProduk']);
Route::post('/storeProduk', [ProdukController::class, 'storeProduk']);
Route::post('/updateProduk/{id}', [ProdukController::class, 'updateProduk']);

// pembelian
Route::get('/pembelian', [PembelianController::class, 'pembelian']);
Route::post('/deletePembelian', [PembelianController::class, 'deletePembelian']);
Route::post('/storePembelian', [PembelianController::class, 'storePembelian']);
Route::post('/updatePembelian/{id}', [PembelianController::class, 'updatePembelian']);

// third party pembelian
Route::get('/provinsi', [PembelianController::class, 'provinsi']);
Route::get('/kota/{id}', [PembelianController::class, 'kota']);
Route::get('/harga/{tujuan}/{berat}/{kurir}', [PembelianController::class, 'harga']);



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

