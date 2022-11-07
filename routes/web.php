<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\API;

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

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('clear-compiled');
    return "Cleared!";
 });
 //Route::get('mail', [API\AdminController::class,'sendMail']);
Route::get('/', [ApplicationController::class, 'index'])->name('user-side');
Route::get('/store/{store}', [ApplicationController::class, 'index'])->name('store');
Route::get('/reset-password', [ApplicationController::class, 'index'])->name('reset-password');
Route::get('/login', [ApplicationController::class, 'index'])->name('login');

Route::middleware('token')->group(function () {
    Route::get('/{any}', [ApplicationController::class, 'index'])->where('any', '.*');
});
