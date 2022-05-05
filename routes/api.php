<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\category\delete_category;
use App\Http\Controllers\Api\category\insert_category;
use App\Http\Controllers\Api\category\readcategory;
use App\Http\Controllers\Api\category\readcategory_byid;
use App\Http\Controllers\Api\category\update_category;

use App\Http\Controllers\Api\users\delete_user;
use App\Http\Controllers\Api\users\insert_user;
use App\Http\Controllers\Api\users\readuser;
use App\Http\Controllers\Api\users\readuser_byid;
use App\Http\Controllers\Api\users\update_user;
use App\Http\Controllers\Api\users\login;


use App\Http\Controllers\Api\food\delete_food;
use App\Http\Controllers\Api\food\insert_food;
use App\Http\Controllers\Api\food\readfood;
use App\Http\Controllers\Api\food\readfood_byid;
use App\Http\Controllers\Api\food\update_food;

use App\Http\Controllers\Api\favorite\delete_favorite;
use App\Http\Controllers\Api\favorite\insert_favorite;
use App\Http\Controllers\Api\favorite\readfavorite;

use App\Http\Controllers\Api\bill\delete_bill;
use App\Http\Controllers\Api\bill\readbill;
use App\Http\Controllers\Api\bill\readbill_d;
use App\Http\Controllers\Api\bill\readdetail_bill;
use App\Http\Controllers\Api\bill\readdetail_bill_d;
use App\Http\Controllers\Api\bill\insert_bill;

use App\Http\Controllers\Api\customer\delete_customer;
use App\Http\Controllers\Api\customer\insert_customer;
use App\Http\Controllers\Api\customer\readcustomer;
use App\Http\Controllers\Api\customer\readcustomer_byid;
use App\Http\Controllers\Api\customer\update_customer;
use App\Http\Controllers\Api\customer\login as customerLogin;

use App\Http\Controllers\Api\delivery\delete_delivery;
use App\Http\Controllers\Api\delivery\insert_delivery;
use App\Http\Controllers\Api\delivery\readdelivery;
use App\Http\Controllers\Api\delivery\readdeliveryr_byid;
use App\Http\Controllers\Api\delivery\update_delivery;



//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  //  return $request->user();
//});


Route::get('login', [LoginController::class,'login']);

Route::post('check', [LoginController::class,'check']);

Route::middleware(['LoginApiMiddleware'])->group(function () {

 Route::group(['prefix' => 'delivery'], function () {

Route::get('/readdelivery', [readdelivery::class ,'getAllDelivery']);
Route::get('/readdelivery_byid', [readdelivery_byid::class ,'getDelivery']);
Route::post('adddelivery', [insert_delivery::class,'addDelivery']);
Route::get('delete_delivery', [delete_delivery::class,'deleteDelivery']);
Route::post('update_deliveryr', [update_delivery::class,'editDelivery']);

});


 Route::group(['prefix' => 'customer'], function () {

Route::get('/readcustomer', [readcustomer::class ,'getAllCustomer']);
Route::get('/readcustomer_byid', [readcustomer_byid::class ,'getCustomer']);
Route::post('addcustomer', [insert_customer::class,'addCustomer']);
Route::get('delete_customer', [delete_customer::class,'deleteCustomer']);
Route::post('update_customer', [update_customer::class,'editCustomer']);
Route::get('/login', [customerLogin::class,'loginCustomer']);

});



 Route::group(['prefix' => 'category'], function () {

Route::get('/readcategory', [readcategory::class ,'getAllCategory']);
Route::get('/readcategory_byid', [readcategory_byid::class ,'getCategory']);
Route::post('addcategory', [insert_category::class,'addCategory']);
Route::get('delete_category', [delete_category::class,'deleteCategory']);
Route::post('update_category', [update_category::class,'editCategory']);

Route::get('/readimage', [readcategory::class ,'image']);

});

Route::group(['prefix' => 'food'], function () {

Route::get('/delete_food', [delete_food::class ,'deleteProduct']);
Route::post('insert_food', [insert_food::class,'addProduct']);
Route::get('readfood', [readfood::class,'getAllProduct']);
Route::get('readfood_byid', [readfood_byid::class,'getProduct']);
Route::post('update_food', [update_food::class,'editProduct']);


});

Route::group(['prefix' => 'favorite'], function () {

Route::get('/readfavorite', [readfavorite::class ,'getfavorite']);
Route::post('insert_favorite', [insert_favorite::class,'addfavorite']);
Route::get('delete_favorite', [delete_favorite::class,'deletefavorite']);

});


Route::group(['prefix' => 'bill'], function () {

Route::get('/readbill', [readbill::class ,'getBill']);
Route::get('/readbill_d', [readbill_d::class ,'getAllBill']);
Route::get('/readdetail_bill', [readdetail_bill::class ,'getDetailBill']);
Route::get('/readdetail_bill_d', [readdetail_bill_d::class ,'getAllDetailBill']);
Route::post('/insert_bill', [insert_bill::class,'addBill']);
Route::get('delete_bill', [delete_bill::class,'deleteBill']);

});



Route::group(['prefix' => 'user'], function () {

Route::get('/readuser', [readuser::class ,'getAllUser']);
Route::get('/readuser_byid', [readuser_byid::class ,'getUser']);
Route::post('adduser', [insert_user::class,'addUser']);
Route::get('delete_user', [delete_user::class,'deleteUser']);
Route::post('update_user', [update_user::class,'editUser']);
Route::post('login', [login::class,'loginUser']);

});

Route::group(['prefix' => 'delivery'], function () {

Route::get('/readdelivery', [DelivaryController::class ,'getAllDelivery']);
Route::post('adddelivery', [DelivaryController::class,'addDelivery']);
Route::get('deletedelivery/{id}', [DelivaryController::class,'deleteDelivery']);
Route::post('editdelivery/{id}', [DelivaryController::class,'editDelivery']);
Route::post('login', [login::class,'loginDelivery']);

});


 
});

Route::get('/readdel', [delController::class ,'getAlldelivery']);

Route::get('editstatus/{id}', [delController::class, 'editstatus']);
Route::get('editstatus2/{id}', [delController::class, 'editstatus2']);

Route::get('/images/category/{name}',[readcategory::class , 'p']);
