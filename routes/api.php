<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Login;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/SignIn',[Login::class,'SignIn']);
Route::get('/HomeDataProduk',[UserController::class,'HomeDataProduk']);
Route::post('/HomeDataProdukWhere',[UserController::class,'HomeDataProdukWhere']);
Route::post('/DetailProduct',[UserController::class,'DetailProduct']);
Route::post('/DetailBerita',[UserController::class,'DetailBerita']);
Route::post('/Pencarian',[UserController::class,'Pencarian']);
Route::post('/DataBerita',[UserController::class,'DataBerita']);
Route::post('/SimpanTamu',[UserController::class,'SimpanTamu']);
Route::get('/DataBanner',[DashboardController::class,'DataBanner']);

Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/SignOut',[Login::class,'SignOut']);
    Route::post('/SimpanKategori',[DashboardController::class,'SimpanKategori']);
    Route::get('/getBarang',[DashboardController::class,'getBarang']);
    Route::post('/ProsesPermintaan',[DashboardController::class,'ProsesPermintaan']);
    Route::get('/DataKategori',[DashboardController::class,'DataKategori']);
    Route::post('/SimpanProduk',[DashboardController::class,'SimpanProduk']);
    Route::get('/DataProduk',[DashboardController::class,'DataProduk']);
    Route::post('/HapusGambarProduk',[DashboardController::class,'HapusGambarProduk']);
    Route::post('/DeleteProduk',[DashboardController::class,'DeleteProduk']);
    Route::post('/DeleteKategori',[DashboardController::class,'DeleteKategori']);
    Route::get('/DataBerita',[DashboardController::class,'DataBerita']);
    Route::post('/SimpanBerita',[DashboardController::class,'SimpanBerita']);
    Route::post('/DeleteBerita',[DashboardController::class,'DeleteBerita']);
    Route::post('/DeleteTamu',[DashboardController::class,'DeleteTamu']);
    Route::get('/DataTamu',[DashboardController::class,'DataTamu']);
    Route::post('/SimpanBanner',[DashboardController::class,'SimpanBanner']);
    Route::get('/DataBanner',[DashboardController::class,'DataBanner']);
    Route::post('/DeleteBanner',[DashboardController::class,'DeleteBanner']);
});
