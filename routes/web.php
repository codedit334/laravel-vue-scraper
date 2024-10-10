<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\Auth\RegisterController;


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
Route::post('/scrape', [ScraperController::class, 'scrape'])->name('scrape');
Route::get('/scrape-activities', [ScraperController::class, 'scrapeActivities']);
Route::get('/sportma', [SportmaController::class, 'show'])->name('sportma');

Route::post('/register', [RegisterController::class, 'register']);