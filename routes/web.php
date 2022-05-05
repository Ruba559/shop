<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\CategoryajaxController;
use App\Http\Controllers\User\UserajaxController;
use App\Http\Controllers\Product\ProductajaxController;
use App\Http\Controllers\Delivery\DeliveryajaxController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Request\RequestController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\Advertising\AdvertisingController;
use App\Http\Controllers\Rule\RuleController;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Calculation\CalculationController;
use App\Http\Controllers\ProductName\ProductNameController;
use App\Http\Controllers\Velocity\VelocityController;


Auth::routes();


Route::group(['namespace' => 'Site'], function () {

    Route::get('/', [SiteController::class , 'index']);
    Route::get('/detail_product/{id}', [SiteController::class , 'detailProduct'])->name('detail_product');
    Route::get('/login_site', [SiteController::class , 'indexLogin']);
    Route::get('/register_site', [SiteController::class , 'indexRegister']);
    Route::get('/index_cart', [SiteController::class , 'indexCart']);
    Route::get('/index_about-us', [SiteController::class , 'indexAboutUs']);
    Route::get('/thankyou', [SiteController::class , 'Thankyou']);

    Route::post('/add_bill', [SiteController::class , 'addBillb']);
    Route::post('/add_fav', [SiteController::class , 'addFavorite']);
    Route::get('/remove_fav/{foo_id}', [SiteController::class , 'removeFavorite']);
    Route::post('/add_cart', [SiteController::class , 'addcart']);
 
    Route::get('/logout_customer',[SiteController::class,'getLogout']);
    
    Route::get('add/{id}', [SiteController::class, 'add']); 
    Route::post('add_to_cart', [SiteController::class, 'addToCart']);
    Route::get('remove-from-cart/{id}', [SiteController::class, 'removeCart']);

    Route::get('autocomplete',[SiteController::class , 'autoComplete'])->name('autocomplete');
    Route::post('/search',[SiteController::class , 'Search']);

    Route::get('post', [SiteController::class, 'post'])->name('post');

    Route::patch('update-cart', [SiteController::class, 'update'])->name('update.cart');
    Route::delete('remove-from-cart', [SiteController::class, 'remove'])->name('remove.from.cart');

    Route::get('/updatetime',[SiteController::class , 'updateTimeDelivery']);

  });


  Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' , 'auth']
    ], function () {
  
      Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


  Route::group(['namespace' => 'Category'], function () {

    Route::get('/add_category', [CategoryajaxController::class , 'indexAdd']);
    Route::get('category', [CategoryajaxController::class, 'index']);
    Route::get('fetch-category', [CategoryajaxController::class, 'fetchCategory']);
    Route::post('category', [CategoryajaxController::class, 'store']);
    Route::get('edit-category/{id}', [CategoryajaxController::class, 'edit']);
    Route::post('update_category', [CategoryajaxController::class, 'update']);
    Route::delete('delete-category/{id}', [CategoryajaxController::class, 'destroy']);
    Route::post('crop_category', [CategoryajaxController::class, 'cropImage']);

  });
  

  Route::group(['namespace' => 'ProductName'], function () {

    Route::get('/add_productname', [ProductNameController::class , 'indexAdd']);
    Route::get('productname', [ProductNameController::class, 'index']);
    Route::get('productprice', [ProductNameController::class, 'indexPrice']);
    Route::get('fetch-productname', [ProductNameController::class, 'fetchProductName']);
    Route::post('productname', [ProductNameController::class, 'store']);
    Route::post('productprice', [ProductNameController::class, 'storePrice']);
    Route::get('edit-productname/{id}', [ProductNameController::class, 'edit']);
    Route::post('update_productname', [ProductNameController::class, 'update']);
    Route::delete('delete-productname/{id}', [ProductNameController::class, 'destroy']);
    Route::post('show_supllier', [ProductNameController::class, 'showSupllier']);

  });
  

  Route::group(['namespace' => 'Product'], function () {
  
    Route::get('/add_product', [ProductajaxController::class , 'indexAdd']);
    Route::get('product', [ProductajaxController::class, 'index']);
    Route::get('fetch-product', [ProductajaxController::class, 'fetchProduct']);
    Route::post('product', [ProductajaxController::class, 'store']);
    Route::get('edit-product/{id}', [ProductajaxController::class, 'edit']);
    Route::post('update_product', [ProductajaxController::class, 'update']);
    Route::delete('delete-product/{id}', [ProductajaxController::class, 'destroy']);
    Route::post('crop_product', [ProductajaxController::class, 'cropImage']);

    //Route::get('product', [ProductController::class, 'index']);

  });


  Route::group(['namespace' => 'Calculation'], function () {
  
    Route::get('calculation', [CalculationController::class, 'index']);
    Route::get('profit', [CalculationController::class, 'indexProfit']);
    Route::get('calculationdelivery', [CalculationController::class, 'calculationDelivery']);
    Route::post('show_delivery', [CalculationController::class, 'showDelivery']);

  });


  Route::group(['namespace' => 'User'], function () {
  
    Route::get('/add_user', [UserajaxController::class , 'indexAdd']);
    Route::get('user', [UserajaxController::class, 'index']);
    Route::get('fetch-user', [UserajaxController::class, 'fetchUser']);
    Route::post('user', [UserajaxController::class, 'store']);
    Route::get('edit-user/{id}', [UserajaxController::class, 'edit']);
    Route::put('update_user', [UserajaxController::class, 'update']);
    Route::delete('delete-user/{id}', [UserajaxController::class, 'destroy']);
    Route::get('/logout',[UserajaxController::class,'getLogout']);
    Route::post('/active-user',[UserajaxController::class, 'Active']);
    Route::post('/unactive-user',[UserajaxController::class, 'UnActive']);
  
  });


  Route::group(['namespace' => 'Delivery'], function () {

    Route::get('/add_delivery', [DeliveryajaxController::class , 'indexAdd']);
    Route::get('delivery', [DeliveryajaxController::class, 'index']);
    Route::get('/fetch-delivery', [DeliveryajaxController::class, 'fetchDelivery']);
    Route::post('delivery', [DeliveryajaxController::class, 'store']);
    Route::get('edit-delivery/{id}', [DeliveryajaxController::class, 'edit']);
    Route::post('update_delivery', [DeliveryajaxController::class, 'update']);
    Route::delete('delete-delivery/{id}', [DeliveryajaxController::class, 'destroy']);   
    Route::post('crop_delivery', [DeliveryajaxController::class, 'cropImage']);
    Route::get('delivery_status', [DeliveryController::class, 'index']);
    Route::post('/filter',[DeliveryController::class, 'filter']);

  });


  Route::group(['namespace' => 'Supplier'], function () {

    Route::get('/add_supplier', [SupplierController::class , 'indexAdd']);
    Route::get('supplier', [SupplierController::class, 'index']);
    Route::get('fetch-supplier', [SupplierController::class, 'fetchSupplier']);
    Route::post('supplier', [SupplierController::class, 'store']);
    Route::get('edit-supplier/{id}', [SupplierController::class, 'edit']);
    Route::Put('update_supplier', [SupplierController::class, 'update']);
    Route::delete('delete-supplier/{id}', [SupplierController::class, 'destroy']);

  });


  Route::group(['namespace' => 'Request'], function () {

    Route::get('request', [RequestController::class, 'index']);
    Route::get('request2', [RequestController::class, 'indextodo']);
    Route::post('bill_detail', [RequestController::class, 'billBetail']);

  });


  Route::group(['namespace' => 'Advertising'], function () {

    Route::get('/add_advertising', [AdvertisingController::class , 'indexAdd']);
    Route::get('advertising', [AdvertisingController::class, 'index']);
    Route::get('fetch-advertising', [AdvertisingController::class, 'fetchAdvertising']);
    Route::post('advertising', [AdvertisingController::class, 'store']);
    Route::get('edit-advertising/{id}', [AdvertisingController::class, 'edit']);
    Route::post('update_advertising', [AdvertisingController::class, 'update']);
    Route::delete('delete-advertising/{id}', [AdvertisingController::class, 'destroy']);
    Route::post('crop_advertising', [AdvertisingController::class, 'cropImage']);

  });


  Route::group(['namespace' => 'Rule'], function () {
  
    Route::get('/add_rule', [RuleController::class , 'indexAdd']);
    Route::get('rule', [RuleController::class, 'index']);
    Route::get('fetch-rule', [RuleController::class, 'fetchRule']);
    Route::post('rule', [RuleController::class, 'store']);
    Route::get('edit-rule/{id}', [RuleController::class, 'edit']);
    Route::put('update_rule', [RuleController::class, 'update']);
    Route::delete('delete-rule/{id}', [RuleController::class, 'destroy']);
    Route::get('detail-rule/{id}', [RuleController::class, 'detail']);
    Route::post('delete_permission', [RuleController::class, 'destroyPermission']);
    Route::post('add_permission', [RuleController::class, 'addPermission']);
 
  });


  Route::group(['namespace' => 'Permission'], function () {
  
    Route::get('/add_permission', [PermissionController::class , 'indexAdd']);
    Route::get('permission', [PermissionController::class, 'index']);
    Route::get('fetch-permission', [PermissionController::class, 'fetchPermission']);
    Route::post('permission', [PermissionController::class, 'store']);
    Route::get('edit-permission/{id}', [PermissionController::class, 'edit']);
    Route::put('update_permission', [PermissionController::class, 'update']);
    Route::delete('delete-permission/{id}', [PermissionController::class, 'destroy']);
 
  });


  Route::group(['namespace' => 'Velocity'], function () {
  
    Route::get('velocity', [VelocityController::class, 'index']);
    Route::get('fetch-velocity', [VelocityController::class, 'fetchVelocity']);
    Route::get('edit-velocity/{id}', [VelocityController::class, 'edit']);
    Route::put('update_velocity', [VelocityController::class, 'update']);
 
  });


});


