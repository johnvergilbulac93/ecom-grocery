<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function () {
    Route::post('uploaditem', 'API\UploadingController@uploaditem');
    Route::post('uploadpending', 'API\UploadingController@uploadPendingItem');
    Route::post('uploadprice', 'API\UploadingController@uploadprice');
    Route::post('uploaduom', 'API\UploadingController@uploaduom');
    Route::post('uploadItemDisable', 'API\UploadingController@uploadItemDisable');
    Route::post('uploadcategory', 'API\UploadingController@uploadcategory');
    Route::post('uploaditemfilename', 'API\UploadingController@uploaditemfilename');

});

Route::middleware('auth:api')->group(function () {
    Route::get('item', 'API\ItemController@getItem');
    Route::get('central_item', 'API\ItemController@getCentralItem');
    Route::get('countitem', 'API\ItemController@countItem');
    Route::get('countprice', 'API\ItemController@countPrice');
    Route::get('countuom', 'API\ItemController@countUOM');
    Route::put('edit_item/{id}', 'API\ItemController@edit_item');
    Route::post('create_item', 'API\ItemController@create_item');
    Route::put('create_uom/{id}', 'API\ItemController@create_uom');
    Route::delete('delete_item/{id}', 'API\ItemController@delete_item');
    Route::get('itemavailable', 'API\ItemController@itemavailability');
    Route::get('item_available_all', 'API\ItemController@item_available_all');
    Route::post('tag_item_disable', 'API\ItemController@tag_item_disable');
    Route::delete('tag_item_enable/{itemcode}', 'API\ItemController@tag_item_enable');
    Route::put('item_Inactive/{itemcode}', 'API\ItemController@item_Inactive');
    Route::put('item_Active/{itemcode}', 'API\ItemController@item_Active');
    Route::put('imageitem/{itemcode}', 'API\ItemController@imageitem');

    Route::get('tagging_uom/disable', 'API\ItemController@disable_tagging_uom');
    Route::post('tagging/per_uom/disable', 'API\ItemController@disable_per_uom');
    
    Route::get('tagging_uom/enable', 'API\ItemController@enable_tagging_uom');
    Route::post('tagging/per_uom/enable', 'API\ItemController@enable_per_uom');
    Route::get('price_changed/count', 'API\ItemController@price_count_changed');
    Route::get('price_changed/info', 'API\ItemController@price_count_changed_info');

    Route::get('show/available/item/store', 'API\ItemController@store_available_item');



});

Route::middleware('auth:api')->group(function () {
    Route::put('min_order_amount/{id}', 'API\SetUpController@min_order_amount');
    Route::put('pickup_charge/{id}', 'API\SetUpController@pickup_charge');
    Route::put('order_time_cutoff/{id}', 'API\SetUpController@order_time_cutoff');
    Route::put('max_order/{id}', 'API\SetUpController@max_order');
    Route::put('serving_time/{id}', 'API\SetUpController@serving_time');
    Route::get('setup_rules', 'API\SetUpController@setup_rules');
    Route::get('pickers', 'API\SetUpController@pickers');
    Route::post('pickercreate', 'API\SetUpController@pickercreate');
    Route::get('getpicker', 'API\SetUpController@getpicker');
    Route::put('pickeredit/{id}', 'API\SetUpController@pickeredit');
    Route::delete('deletepicker/{id}', 'API\SetUpController@deletepicker');
    Route::get('gettimepickup', 'API\SetUpController@gettimepickup');
    Route::put('pickuptime_edit/{id}', 'API\SetUpController@pickuptime_edit');

    Route::get('business_time', 'API\SetUpController@business_time');
    Route::post('business_time/create', 'API\SetUpController@add_business_time');
    Route::put('business_time/edit/{id}', 'API\SetUpController@edit_business_time');

    Route::post('tenant/create', 'API\SetUpController@add_tenant');
    Route::get('tenants', 'API\SetUpController@tenants');
    Route::put('tenant/edit/{id}', 'API\SetUpController@edit_tenant');
    Route::delete('tenant/delete/{id}', 'API\SetUpController@delete_tenant');

    Route::get('departments', 'API\SetUpController@departments');
    Route::post('minimum/create', 'API\SetUpController@create_minimum');
    Route::get('minimum/amounts', 'API\SetUpController@amounts');
    Route::put('minimum/amounts/edit/{id}', 'API\SetUpController@edit_minimum');
    Route::delete('minimum/amounts/delete/{id}', 'API\SetUpController@delete_minimum');

    Route::get('province', 'API\SetUpController@province');
    Route::get('town', 'API\SetUpController@town');
    Route::get('barangay', 'API\SetUpController@barangay');
    Route::get('transportations', 'API\SetUpController@transportation');

    Route::get('show/charges', 'API\SetUpController@show_charge');
    Route::post('create/charge', 'API\SetUpController@create_charge');
    Route::delete('charges/remove/{id}', 'API\SetUpController@delete_charges');

});

Route::middleware('auth:api')->group(function () {
    Route::get('users', 'API\UserController@getusers');
    Route::get('userAdmin', 'API\UserController@getUsersAdmin');
    Route::get('usertype', 'API\UserController@usertype');
    Route::get('usertypeAdmin', 'API\UserController@usertypeAdmin');
    Route::put('edit_user/{id}', 'API\UserController@edit_user');
    Route::put('edit_super_user/{id}', 'API\UserController@edit_super_user');
    Route::delete('delete_user/{id}', 'API\UserController@delete_user');
    Route::delete('delete_super_user/{id}', 'API\UserController@delete_super_user');
    Route::post('add_user', 'API\UserController@add_user');
    Route::post('add_super_user', 'API\UserController@add_super_user');
    Route::get('stores', 'API\UserController@getStores');
    Route::get('employee', 'API\UserController@employees');

    Route::post('updateprofile', 'API\UserController@updateprofile');

});

Route::middleware('auth:api')->group(function () {
    Route::get('filter_report', 'API\ReportController@index');
    Route::get('filter_report_store', 'API\ReportController@store_item');
    Route::get('liquidation/report', 'API\ReportController@getLiquidation');
    // Route::get('reports', 'ReportController@showReport');
});
