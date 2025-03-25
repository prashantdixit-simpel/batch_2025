<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('list',[UserController::class,'user_list'])->->name('users.list');
// Route::post('users/register',[UserController::class,'register_user']);
// Route::post('user/detail',[UserController::class,'user_detail']);
// Route::put('user/update',[UserController::class,'user_update']);


// group route
// Route::group(['prefix'=>'users/'],function(){
//     Route::get('list',[UserController::class,'user_list']);   //users.list
//     Route::post('register',[UserController::class,'register_user']);
//     Route::post('detail',[UserController::class,'user_detail']);
//     Route::put('update',[UserController::class,'user_update']);
// });


Route::group(['prefix'=>'users/','controller'=>UserController::class],function(){
    Route::post('list','user_list');   //users.list
    Route::post('register','register_user');
    Route::post('detail','user_detail');
    Route::put('update','user_update');
});

Route::group(['prefix'=>'customer/','controller'=>CustomerController::class],function(){
    Route::get('list','customer_list');   //customers.list
    Route::post('register','register_customer');
    Route::post('detail','customer_detail');
    Route::put('update','customer_update');
    Route::put('destroy','customer_destroy');

});

Route::post('/get_connection_id',[AuthController::class,'get_connection_id']);
Route::post('/request_otp',[AuthController::class,'request_otp']);

Route::post('login',[AuthController::class,'login']);
Route::post('register_customer',[AuthController::class,'register_customer']);
Route::post('profile_details',[CustomerController::class,'profile_details']);


// list of customers for pending payment_status
Route::post('/customer_listing',[CustomerController::class,'customer_listing']);