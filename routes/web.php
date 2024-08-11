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
Route::get('/data-search', [TikTokController::class, 'searchResult'])->name('tiktok.scrap.username');
Route::get('/load/scrap-username', [TikTokController::class, 'loadSearchResult'])->name('tiktok.load.scrap.username');
Route::get('/data-search/detail/{a}', [TikTokController::class, 'detailSearchResults'])->name('tiktok.search.detail');
Route::get('/load/data-search/detail/{a}', [TikTokController::class, 'loadDetailSearchResults'])->name('titkok.load.results');
Route::get('/data-search/profile/{a}', [TikTokController::class, 'dataSearchProfile'])->name('titkok.data.search.profile');
Route::get('/export-data/{a}', [TikTokController::class, 'exportTikTokAccounts'])->name('tiktok.account.export');
Route::get('/data-search/profile/videos/{a}', [TikTokController::class, 'scrapVideoTiktokAccount'])->name('tiktok.account.videos');
Route::get('/load/data-search/profile/videos/{a}', [TikTokController::class, 'loadTiktokAccountVideo'])->name('tiktok.load.account.videos');

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
