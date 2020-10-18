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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\Users\ApiLoginController@login');

// manage data routes
Route::group(['prefix' => 'managedata'],function ($api) {
    $api->post('/', 'Api\ManageData\ApiManageDataController@manage');
    $api->get('/', 'Api\ManageData\ApiManageDataController@manage');
});

// api payments
Route::post('/payments', 'Api\Payment\ApiPaymentController@store')->name('payments.store');

Route::group(['middleware' => 'auth:api'], function() {

	// export to excel data...
	Route::get('excel/smsoutbox/{type}', 'ExcelController@exportOutboxSmsToExcel')->name('excel.smsoutbox');
	Route::get('excel/mpesa-incoming/{type}', 'ExcelController@exportMpesaIncomingToExcel')->name('excel.mpesa-incoming');
	Route::get('excel/payments/{type}', 'ExcelController@exportPaymentsToExcel')->name('excel.payments');
	Route::get('excel/admin/offers/{type}', 'ExcelController@exportOffersToExcel')->name('excel.admin.offers');

	// shopping cart
	Route::get('/review-order', 'Web\ShoppingCart\ShoppingCartController@reviewOrder')->name('review-order');
	Route::get('/review-order/make-payment/{id}', 'Web\ShoppingCart\ShoppingCartController@makePayment')->name('make-payment');
	Route::post('/review-order/make-payment', 'Web\ShoppingCart\ShoppingCartController@makePaymentRequestStore')->name('make-payment-request-store');
	Route::get('/payment-status/{id}', 'Web\ShoppingCart\ShoppingCartController@makePaymentResult')->name('payment-status');
	Route::get('/my-shopping-cart', 'Web\ShoppingCart\ShoppingCartController@index')->name('my-shopping-cart');
	Route::post('/my-shopping-cart', 'Web\ShoppingCart\ShoppingCartController@store')->name('my-shopping-cart.store');
	Route::post('/my-shopping-cart/update-cart-items', 'Web\ShoppingCart\ShoppingCartController@updateCartItems')->name('my-shopping-cart.updateCartItems');

    // shopping cart item controller
    Route::delete('/my-shopping-cart-item/{id}', 'Web\ShoppingCartItem\ShoppingCartItemController@destroy')->name('my-shopping-cart-item.destroy');

	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	// orders routes...
    Route::get('/orders/addItemToCart', 'Web\Order\OrderController@addItemToCart')->name('orders.addItemToCart');

    // Payments
    // Route::apiResource('/payments', 'Api\Payment\ApiPaymentController', ['except' => ['store', 'destroy']]);
    //payments routes...
	Route::get('/payments', 'Api\Payment\ApiPaymentController@index')->name('payments.index');
	Route::get('/payments/{id}', 'Api\Payment\ApiPaymentController@show')->name('payments.show');
	Route::get('/payments/{id}/edit', 'Api\Payment\ApiPaymentController@edit')->name('payments.edit');
	Route::put('/payments/{id}/update', 'Api\Payment\ApiPaymentController@update')->name('payments.update');
	Route::get('/payments/{id}/repost', 'Api\Payment\ApiPaymentController@repost')->name('payments.repost');

});
