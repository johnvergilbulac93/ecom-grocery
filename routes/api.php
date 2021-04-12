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
    Route::post('uploaditem', 'API\UploadingController@uploaditem')->name('upload-item');
    Route::post('uploadpending', 'API\UploadingController@uploadPendingItem')->name('upload-pending-item');
    Route::post('uploadprice', 'API\UploadingController@uploadprice')->name('upload-price');
    Route::post('uploaduom', 'API\UploadingController@uploaduom')->name('upload-uom');
    Route::post('uploadItemDisable', 'API\UploadingController@uploadItemDisable')->name('upload-item-disable');
    Route::post('uploadcategory', 'API\UploadingController@uploadcategory')->name('upload-category');
    Route::post('uploaditemfilename', 'API\UploadingController@uploaditemfilename')->name('upload-item-filename');
    Route::post('uploadmultiple', 'API\UploadingController@multipleImage')->name('multiple-image');
});

Route::middleware('auth:api')->group(function () {

    Route::get('item', 'API\ItemController@getItem')->name('get-item');
    Route::get('central_item', 'API\ItemController@getCentralItem')->name('get-central-item');
    Route::get('countitem', 'API\ItemController@countItem')->name('count-item');
    Route::get('countprice', 'API\ItemController@countPrice')->name('count-price');
    Route::get('countuom', 'API\ItemController@countUOM')->name('count-uom');
    Route::put('edit_item/{id}', 'API\ItemController@edit_item')->name('edit-item');
    Route::post('create_item', 'API\ItemController@create_item')->name('create-item');
    Route::put('create_uom/{id}', 'API\ItemController@create_uom')->name('create-uom');
    Route::delete('delete_item/{id}', 'API\ItemController@delete_item')->name('delete-item');
    Route::get('itemavailable', 'API\ItemController@itemavailability')->name('item-availability');
    Route::get('item_available_all', 'API\ItemController@item_available_all')->name('item-available-all');
    Route::post('tag_item_disable', 'API\ItemController@tag_item_disable')->name('tag-item-disable');
    Route::delete('tag_item_enable/{itemcode}', 'API\ItemController@tag_item_enable')->name('tag-item-enable');
    Route::put('item_Inactive/{itemcode}', 'API\ItemController@item_Inactive')->name('item-inactive');
    Route::put('item_Active/{itemcode}', 'API\ItemController@item_Active')->name('item-active');
    Route::put('imageitem/{itemcode}', 'API\ItemController@imageitem')->name('image-item');

    Route::get('tagging_uom/disable', 'API\ItemController@disable_tagging_uom')->name('disable-tagging-uom');
    Route::post('tagging/per_uom/disable', 'API\ItemController@disable_per_uom')->name('disable-per-uom');

    Route::get('tagging_uom/enable', 'API\ItemController@enable_tagging_uom')->name('enable-tagging-uom');
    Route::post('tagging/per_uom/enable', 'API\ItemController@enable_per_uom')->name('enable-per-uom');
    Route::get('price_changed/count', 'API\ItemController@price_count_changed')->name('price-count-changed');
    Route::get('price_changed/info', 'API\ItemController@price_count_changed_info')->name('price-count-changed-info');

    Route::get('show/available/item/store', 'API\ItemController@store_available_item')->name('store-available-item');
    Route::get('count/category', 'API\ItemController@count_per_category')->name('count-per-category');
    Route::post('selected/disable/item', 'API\ItemController@disabled_selected_item')->name('disabled-selected-item');
    Route::post('selected/enable/item', 'API\ItemController@enabled_selected_item')->name('enabled-selected-item');
});

Route::middleware('auth:api')->group(function () {
    Route::put('min_order_amount/{id}', 'API\SetUpController@min_order_amount')->name('min-order-amount');
    Route::put('pickup_charge/{id}', 'API\SetUpController@pickup_charge')->name('pickup-charge');
    Route::put('order_time_cutoff/{id}', 'API\SetUpController@order_time_cutoff')->name('order-time-cutoff');
    Route::put('max_order/{id}', 'API\SetUpController@max_order')->name('max-order');
    Route::put('serving_time/{id}', 'API\SetUpController@serving_time')->name('serving-time');
    
    Route::get('setup_rules', 'API\SetUpController@setup_rules')->name('setup-rules');
    Route::get('pickers', 'API\SetUpController@pickers')->name('pickers');
    Route::post('pickercreate', 'API\SetUpController@pickercreate')->name('picker-create');
    Route::get('getpicker', 'API\SetUpController@getpicker')->name('get-picker');
    Route::put('pickeredit/{id}', 'API\SetUpController@pickeredit')->name('picker-edit');
    Route::delete('deletepicker/{id}', 'API\SetUpController@deletepicker')->name('picker-delete');
    Route::get('gettimepickup', 'API\SetUpController@gettimepickup')->name('get-time-pickup');
    Route::put('pickuptime_edit/{id}', 'API\SetUpController@pickuptime_edit')->name('pickup-time-edit');

    Route::get('business_time', 'API\SetUpController@business_time')->name('business-time');
    Route::post('business_time/create', 'API\SetUpController@add_business_time')->name('add-business-time');
    Route::put('business_time/edit/{id}', 'API\SetUpController@edit_business_time')->name('edit-business-time');

    Route::post('tenant/create', 'API\SetUpController@add_tenant')->name('add-tenant');
    Route::get('tenants', 'API\SetUpController@tenants')->name('tenants');
    Route::put('tenant/edit/{id}', 'API\SetUpController@edit_tenant')->name('edit-tenant');
    Route::delete('tenant/delete/{id}', 'API\SetUpController@delete_tenant')->name('delete-tenant');

    Route::get('departments', 'API\SetUpController@departments')->name('departments');
    Route::post('minimum/create', 'API\SetUpController@create_minimum')->name('create-minimum');
    Route::get('minimum/amounts', 'API\SetUpController@amounts')->name('amounts');
    Route::put('minimum/amounts/edit/{id}', 'API\SetUpController@edit_minimum')->name('edit-minimum');
    Route::delete('minimum/amounts/delete/{id}', 'API\SetUpController@delete_minimum')->name('delete-minimum');

    Route::get('province', 'API\SetUpController@province')->name('province');
    Route::get('town', 'API\SetUpController@town')->name('town');
    Route::get('barangay', 'API\SetUpController@barangay')->name('barangay');
    Route::get('transportations', 'API\SetUpController@transportation')->name('transportation');
    Route::get('filter/towns', 'API\SetUpController@filter_town')->name('filter.towns');
    Route::get('view/towns', 'API\SetUpController@show_town')->name('view.towns');
    Route::get('view/brgy', 'API\SetUpController@show_brgy')->name('view.brgy');

    Route::get('show/charges', 'API\SetUpController@show_charge')->name('show-charge');
    Route::post('create/charge', 'API\SetUpController@create_charge')->name('create-charge');
    Route::delete('charges/remove/{id}', 'API\SetUpController@delete_charges')->name('delete-charges');
    Route::get('charges/view/{id}', 'API\SetUpController@view_by_id_charges')->name('view-by-id-charges');
    Route::post('charges/update', 'API\SetUpController@update_charge')->name('update-charges');



});

Route::middleware('auth:api')->group(function () {
    Route::get('users', 'API\UserController@getusers')->name('users');
    Route::get('userAdmin', 'API\UserController@getUsersAdmin')->name('get-user-admin');
    Route::get('usertype', 'API\UserController@usertype')->name('user-type');
    Route::get('usertypeAdmin', 'API\UserController@usertypeAdmin')->name('user-type-admin');
    Route::put('edit_user/{id}', 'API\UserController@edit_user')->name('edit-user');
    Route::put('edit_super_user/{id}', 'API\UserController@edit_super_user')->name('edit-super-user');
    Route::delete('delete_user/{id}', 'API\UserController@delete_user')->name('delete-user');
    Route::delete('delete_super_user/{id}', 'API\UserController@delete_super_user')->name('delete-super-user');
    Route::post('add_user', 'API\UserController@add_user')->name('add-user');
    Route::post('add_super_user', 'API\UserController@add_super_user')->name('add-super-user');
    Route::get('stores', 'API\UserController@getStores')->name('get-stores');
    Route::get('employee', 'API\UserController@employees')->name('employees');
    Route::post('updateprofile', 'API\UserController@updateprofile')->name('update-profile');
});

Route::middleware('auth:api')->group(function () {
    Route::get('filter_report', 'API\ReportController@index')->name('filter-report');
    Route::get('filter_report_store', 'API\ReportController@store_item')->name('filter-report-store');
    Route::get('liquidation/report', 'API\ReportController@getLiquidation')->name('get-liquidition');
    Route::get('accountability/report', 'API\ReportController@getAccountability')->name('get-accountability');
    Route::get('liquidation/store/report', 'API\ReportController@getLiquidation_store')->name('get-liquidition-store');
    Route::get('accountability/store/report', 'API\ReportController@getAccountability_store')->name('get-accoutability-store');
    Route::get('transactions/report', 'API\ReportController@getTransactions')->name('get-transactions');
});

// Route::middleware('auth:api')->group(function () {
//     Route::get('transactions/today', 'API\TransactionsController@get_transactions_today');
// 
// });
