<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\ProductController;
use App\http\Controllers\AuthController;
use App\http\Controllers\OrderController;
use App\http\Controllers\CustomerController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


//public routes

//new public routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


//protected routes
Route::group(['middleware' => ['auth:sanctum']],function(){

    //product api
    Route::get('products/search/{name}',[ProductController::class,'search']);
    Route::post('/products',[ProductController::class,'store']);
    Route::put('products/{id}',[ProductController::class,'update']);
    Route::delete('products/{id}',[ProductController::class,'destroy']);
    Route::get('/products',[ProductController::class,'index']);
    Route::get('products/{id}',[ProductController::class,'show']);

    //logout api
    Route::post('/logout',[AuthController::class,'logout']);

    //order api
    Route::post('/addOrder',[OrderController::class,'addOrder']);
    Route::get('/allOrders',[OrderController::class,'getAllOrder']);

    //customer api
    Route::post('/addcustomer',[CustomerController::class,'addCustomer']);
    Route::get('/allcustomers',[CustomerController::class,'getAllCustomer']);
});
