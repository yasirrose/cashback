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

Route::post('/forgotPassword', [API\LoginController::class, 'forgotPassword']);
Route::post('/resetPassword', [API\LoginController::class, 'resetPassword']);
// Route::get('/reset-password/{token}', function ($token) {
//     return response()->json(['status'=>200,'message' => $token]);   
//})->middleware('guest')->name('password.reset');

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
    Route::post('addCashback', [API\AdminController::class, 'addCashback']); 
    Route::get('getCashbacks', [API\AdminController::class, 'getCashbacks']); 
    Route::get('deleteCashback/{id}', [API\AdminController::class,'deleteCashback']);
    Route::post('deleteMultiCashbacks', [API\AdminController::class,'deleteMultiCashbacks']);
    Route::post('updateAppSetting', [API\AdminController::class,'updateAppSetting']);
    Route::post('updateCashback', [API\AdminController::class,'updateCashback']);
    Route::get('getAppSetting/{id}', [API\AdminController::class, 'getAppSetting']); 
    Route::get('getCashback/{id}', [API\AdminController::class, 'getCashback']); 
    Route::post('addStore', [API\AdminController::class,'addStore']);
    Route::get('getStores', [API\AdminController::class, 'getStores']); 
    Route::get('deleteStore/{id}', [API\AdminController::class,'deleteStore']);
    Route::post('deleteMultiStores', [API\AdminController::class,'deleteMultiStores']);
    Route::get('getStore/{id}', [API\AdminController::class, 'getStore']); 
    Route::post('updateStore', [API\AdminController::class,'updateStore']);
    Route::post('getCashbacksS', [API\AdminController::class,'getCashbacksS']);
    Route::post('getStoresS', [API\AdminController::class,'getStoresS']);
    Route::post('getUsersS', [API\AdminController::class,'getUsersS']);
});


Route::group(['prefix' => 'client'], function(){
    Route::get('getCashbacks', [API\ClientController::class, 'getCashbacks']);
    Route::get('getStores', [API\ClientController::class, 'getStores']);  
    Route::get('getStore/{id}', [API\ClientController::class, 'getStore']);  
    
});