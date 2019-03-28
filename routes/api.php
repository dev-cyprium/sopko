<?php

use Illuminate\Http\Request;
use App\Http\Middleware\ApiAuthMiddleware;

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
Route::post("/account", "AccountController@store");
Route::post("/login", "LoginController@login");

Route::middleware([ApiAuthMiddleware::class])->group(function() {    
    Route::resource('/categories', 'CategoryController');
    Route::resource('/images', 'ImageController');
    Route::resource('/products', 'ProductController');
    
    Route::group(['prefix' => 'admin'], function() {
        Route::resource('/products', 'Admin\ProductController')->only('index');
        Route::resource('/storages', 'Admin\StorageController');
    });
});
