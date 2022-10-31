<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

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


Route::post('login', [API\LoginController::class, 'login']);

Route::post('register', [API\RegisterController::class, 'register']);
// Route::post('logout','UserController@logoutApi');
// Route::post('logout', [API\LoginController::class, 'logoutApi']);
Route::middleware('token')->group(function () {
    Route::post('logout', [API\LoginController::class, 'logout']); 
});

Route::get('/all_users', [API\LoginController::class,'all_users']);
Route::put('/update_user_profile/{id}', [API\LoginController::class,'update_user_profile']);
    
Route::group(['prefix' => 'admin',  'middleware' => 'token'], function(){

    Route::get('getAdminInfo', [API\AdminController::class, 'getAdminInfo']); 
    Route::post('updateAdminInfo', [API\AdminController::class, 'updateAdminInfo']); 
    Route::post('updatePassword', [API\AdminController::class, 'updatePassword']); 
    Route::post('updateEmail', [API\AdminController::class, 'updateEmail']);
    Route::get('getUserLogs', [API\AdminController::class, 'getUserLogs']);
    Route::get('getAppLinks', [API\AdminController::class, 'getAppLinks']);
    Route::post('createUser', [API\AdminController::class, 'createUser']);
    Route::get('getUsers', [API\AdminController::class, 'getUsers']);
    Route::post('updateProfileInfo', [API\AdminController::class, 'updateProfileInfo']);
    Route::get('getUserProfile/{id}', [API\AdminController::class, 'getUserProfile']);
    Route::get('deleteUser/{id}', [API\AdminController::class,'deleteUser']);
    Route::post('deleteMultiUsers', [API\AdminController::class,'deleteMultiUsers']);
    Route::post('updateUserProfile', [API\AdminController::class, 'updateUserProfile']); 
});


Route::group(['prefix' => 'client',  'middleware' => 'token'], function(){
    
});