<?php

use Illuminate\Http\Request;

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

Route::post('register', 'API\RegisterController@register');

Route::middleware('auth:api')->group(function () {
   Route::resource('products', 'API\ProductController');
   Route::resource('suppliers', 'API\SupplierController');
   Route::resource('supplier/products', 'API\SupplierProductController');
   Route::resource('orders', 'API\OrderController');
   Route::resource('order/details', 'API\OrderDetailController');

   Route::get('/users', function (Request $request){
       return response()->json(['name' => Auth::User()->name]);
   });

});



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
