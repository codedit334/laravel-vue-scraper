<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;


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

Route::get('/{any}', function () {
    return view('welcome'); // or whatever view you use for Vue
})->where('any', '.*');

Route::post('/scrape', [ScraperController::class, 'scrape'])->name('scrape');
Route::post('/api/register', [RegisterController::class, 'register']);

Route::post('/api/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [LoginController::class, 'logout']);