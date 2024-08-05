<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TikTokController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/tiktok/search', [TikTokController::class, 'search'])->name('tiktok.search');
Route::get('/scrap-username', [TikTokController::class, 'scrapTikTokUsername'])->name('tiktok.scrap.username');
Route::get('/load/scrap-username', [TikTokController::class, 'loadScrapTikTokUsername'])->name('tiktok.load.scrap.username');
Route::get('/update/scrap-username', [TikTokController::class, 'updateScrapTikTokUsername'])->name('tiktok.update.scrap.username');
Route::get('/tiktok/detail/{id}', [TikTokController::class, 'detail'])->name('tiktok.detail');

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
