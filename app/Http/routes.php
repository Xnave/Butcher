<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
	return view('index')->with(['customers' => \App\Models\Customer::all()]);
});

Route::resource('Customers', 'CustomersController');

//Special prices
Route::post('Customers/SpecialPrice/{id}', ['uses' => 'CustomersController@deleteSpecialPrice']);
Route::post('Customers/SpecialPrice/add/{id}', ['uses' => 'CustomersController@storeSpecialPrice']);

//Orders
Route::get('Customers/{id}/Orders', 'OrdersController@show');
Route::get('openOrders', 'OrdersController@openOrders');
Route::post('Customers/Orders/store', 'OrdersController@store');
Route::DELETE('Customers/Orders/{id}', 'OrdersController@destroy');
Route::post('Customers/Orders/done', ['uses' => 'OrdersController@doneOrder']);
Route::post('Customers/Orders/done/undo', ['uses' => 'OrdersController@doneOrderUndo']);
Route::post('Customers/Orders/paid', ['uses' => 'OrdersController@paidOrder']);
Route::post('Customers/Orders/paid/undo', ['uses' => 'OrdersController@paidOrderUndo']);
Route::post('Customers/Orders/changeDate', ['uses' => 'OrdersController@changeDate']);
Route::post('Customers/Orders/recoverItem', ['uses' => 'OrdersController@recoverItem']);

//Order items
Route::DELETE('Customers/Orders/OrderItems/{id}', ['uses' => 'OrdersController@deleteOrderItem']);
Route::post('Customers/Orders/{id}/OrderItems/add', ['uses' => 'OrdersController@storeOrderItem']);
Route::post('Customers/Orders/OrderItem/UpdateWeight', 'OrdersController@updateWeight');
Route::get('Customers/Orders/{id}/deletedItems', ['uses' => 'OrdersController@OrderDeletedItems']);

//JSOM API
Route::get('allOpenOrders', 'OrdersController@allOpenOrders');
Route::get('allDoneNonPaidOrders', 'OrdersController@allDoneNonPaidOrders');
Route::get('allPaidOrders', 'OrdersController@allPaidOrders');

//Manager
Route::get('undoneOrderItems', 'OrdersController@undoneOrderItems');
//Route::get('OrderItems/{id}', 'OrdersController@getOrderItems');
//Route::get('Products', 'OrdersController@getProducts');
//Route::get('Units', 'OrdersController@getUnits');

Route::get('partials/Orders', function(){
	View::addExtension('html', 'php');
	return View::make('partials/orderTable');
});

// Anything else
Route::get('{any}', function(){
	return view('404');
})->where('any', '.+');
