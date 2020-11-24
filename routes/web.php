<?php

// use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$site_settings = app('site_settings');
View::share('site_settings', $site_settings);


View::share('passport_client_id', \Config::get('constants.passport.client_id'));
View::share('passport_client_secret', \Config::get('constants.passport.client_secret'));
View::share('passport_login_url', \Config::get('constants.passport.login_url'));
View::share('passport_user_url', \Config::get('constants.passport.user_url'));


View::share('get_users_url', \Config::get('constants.routes.get_users_url'));
View::share('send_message_url', \Config::get('constants.routes.send_message_url'));
View::share('create_user_url', \Config::get('constants.routes.create_user_url'));
View::share('create_message_url', \Config::get('constants.routes.create_message_url'));
View::share('fetch_savings_deposit_accounts_url', \Config::get('constants.routes.fetch_savings_deposit_accounts_url'));
View::share('product_category_change_url', \Config::get('constants.routes.product_category_change_url'));
View::share('product_change_url', \Config::get('constants.routes.product_change_url'));
View::share('company_product_verify_url', \Config::get('constants.routes.company_product_verify_url'));

/* START CACHE ROUTES */
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//Link image storage dir:
Route::get('/storage-link', function() {
    $exitCode = Artisan::call('storage:link');
    return '<h1>The [public/storage] directory has been linked</h1>';
});

/* END CACHE ROUTES */

/* PUBLIC ROUTES
 */
Route::get('/', 'Web\HomeController@index')->name('home');

// Route::get('/register', 'Web\HomeController@index')->name('register');
Route::get('/aboutus', 'Web\HomeController@index')->name('aboutus');
Route::get('/contact-us', 'Web\HomeController@contacts')->name('contacts');
Route::post('/contact-us', 'Web\HomeController@contactsStore')->name('contacts.store');

Route::get('/events', 'Web\HomeController@index')->name('events');
Route::get('/restaurants', 'Web\HomeController@index')->name('restaurants');
Route::get('/discounts', 'Web\HomeController@index')->name('discounts');
Route::get('/howtobuy', 'Web\HomeController@index')->name('howtobuy');
Route::get('/faqs', 'Web\HomeController@index')->name('faqs');
Route::get('/search', 'Web\HomeController@index')->name('search');

// clubs
Route::get('/clubs', 'Web\CompanyController@index')->name('clubs');
Route::get('/clubs/{id}', 'Web\CompanyController@show')->name('clubs.show');
Route::get('/events', 'Web\CompanyController@index')->name('events');
Route::get('/restaurants', 'Web\CompanyController@index')->name('restaurants');

// offers
Route::get('/offers', 'Web\OfferFrontController@index')->name('offers');
Route::get('/offers/{id}', 'Web\OfferFrontController@show')->name('offers.show');
Route::get('/clubs/{company_link}/offers', 'Web\OfferFrontController@getClubOffers')->name('offers.showClubOffers');
Route::get('/clubs/{company_link}/offers/{offer_link}', 'Web\OfferFrontController@getClubOffer')->name('offers.showClubOffer');


Route::get('/restaurants/{company}/offers/{offer}', 'Web\CompanyController@getClubOffer')->name('restaurant-offer');
Route::get('/events/{company}/offers/{offer}', 'Web\CompanyController@getClubOffer')->name('event-offer');

// activate till
Route::get('/admin/tills/actv/{activationCode}', 'Web\Admin\Till\TillController@activateTill')->name('admin.tills.actv');

// get offer products for frontend
Route::get('/offer-products/{id}/cart-product-details',
    'Web\OfferProductFront\OfferProductFrontController@getCartProductDetails')->name('offer-products.getCatProductDetails');
Route::resource('/offer-products', 'Web\OfferProductFront\OfferProductFrontController', ['names' => [
    'index' => 'offerproductsfront.index',
    'create' => 'offerproductsfront.create',
    'show' => 'offerproductsfront.show',
]]);

Route::group(['middleware' => 'auth'], function() {

	//export to excel data...
	Route::get('excel/export-smsoutbox/{type}', 'ExcelController@exportOutboxSmsToExcel')->name('excel.export-smsoutbox');
	Route::get('excel/export-groups/{type}', 'ExcelController@exportGroupsToExcel')->name('excel.export-groups');
	Route::get('excel/mpesa-incoming/{type}', 'ExcelController@exportMpesaIncomingToExcel')->name('excel.mpesa-incoming');
	Route::get('excel/payments/{type}', 'ExcelController@exportPaymentsToExcel')->name('excel.payments');
	Route::get('excel/ussd-registration/{type}', 'ExcelController@exportUssdRegistrationToExcel')->name('excel.ussd-registration');
	Route::get('excel/ussd-events/{type}', 'ExcelController@exportUssdEventsToExcel')->name('excel.ussd-events');
	Route::get('excel/ussd-payments/{type}', 'ExcelController@exportUssdPaymentsToExcel')->name('excel.ussd-payments');
	Route::get('excel/ussd-recommends/{type}', 'ExcelController@exportUssdRecommendsToExcel')->name('excel.ussd-recommends');
	Route::get('excel/ussd-contactus/{type}', 'ExcelController@exportUssdContactUsToExcel')->name('excel.ussd-contactus');
	Route::get('excel/loan-applications/{type}', 'ExcelController@exportLoanApplicationsToExcel')->name('excel.loan-applications');
	Route::get('excel/loans/{type}', 'ExcelController@exportLoanApplicationsToExcel')->name('excel.loans');
	Route::get('excel/establishments/{type}', 'ExcelController@exportUserSavingsAccountsToExcel')->name('excel.establishments');
	Route::get('excel/orders/{type}', 'ExcelController@exportUserSavingsAccountsToExcel')->name('excel.orders');

	Route::get('excel/products/{type}', 'ExcelController@exportProductsToExcel')->name('excel.products');
	Route::get('excel/companyproducts/{type}', 'ExcelController@exportCompanyProductsToExcel')->name('excel.companyproducts');
	Route::get('excel/admin/tills/{type}', 'ExcelController@exportCompanyProductsToExcel')->name('excel.admin.tills');

	Route::get('excel/savings-deposit-accounts/{type}', 'ExcelController@exportDepositSavingsAccountsToExcel')->name('excel.savings-deposit-accounts');
	Route::get('excel/deposit-accounts/{type}', 'ExcelController@exportDepositAccountsToExcel')->name('excel.deposit-accounts');
	Route::get('excel/loan-repayment-deposit-accounts/{type}', 'ExcelController@exportDepositLoanRepaymentAccountsToExcel')->name('excel.loan-repayment-deposit-accounts');
	Route::get('excel/company-join-requests/{type}', 'ExcelController@exportDepositLoanRepaymentAccountsToExcel')->name('excel.company-join-requests');

	Route::get('excel/transfers/{type}', 'ExcelController@exportTransfersToExcel')->name('excel.transfers');
	Route::get('excel/deposit-accounts-history/{type}', 'ExcelController@exportDepositAccountHistoryToExcel')->name('excel.deposit-accounts-history');
	Route::get('excel/deposit-accounts-summary/{type}', 'ExcelController@exportDepositAccountSummaryToExcel')->name('excel.deposit-accounts-summary');
	Route::get('excel/shares-accounts-history/{type}', 'ExcelController@exportDepositAccountHistoryToExcel')->name('excel.shares-accounts-history');
	Route::get('excel/shares-accounts-summary/{type}', 'ExcelController@exportDepositAccountSummaryToExcel')->name('excel.shares-accounts-summary');
	Route::get('excel/gl-accounts-history/{type}', 'ExcelController@exportGlAccountHistoryToExcel')->name('excel.gl-accounts-history');
	Route::get('excel/gl-accounts-summary/{type}', 'ExcelController@exportGlAccountSummaryToExcel')->name('excel.gl-accounts-summary');

	Route::get('excel/assets/{type}', 'ExcelController@exportDepositLoanRepaymentAccountsToExcel')->name('excel.assets');

	Route::get('excel/admin/offers/{type}', 'ExcelController@exportOffersToExcel')->name('excel.admin.offers');

    // my transactions routes
    Route::get('/my-transactions', 'Web\MyTransaction\MyTransactionController@index')->name('my-transactions.index');
    Route::get('/my-transactions/create', 'Web\MyTransaction\MyTransactionController@create')->name('my-transactions.create');
    Route::get('/my-transactions/create-step2/{id}', 'Web\MyTransaction\MyTransactionController@create_step2')->name('my-transactions.create-step2');
    Route::get('/my-transactions/create-step3/{id}', 'Web\MyTransaction\MyTransactionController@create_step3')->name('my-transactions.create-step3');
    Route::post('/my-transactions/store', 'Web\MyTransaction\MyTransactionController@store')->name('my-transactions.store');
    Route::post('/my-transactions/store-step2', 'Web\MyTransaction\MyTransactionController@storeStep2')->name('my-transactions.store-step2');
    Route::post('/my-transactions/store-step3', 'Web\MyTransaction\MyTransactionController@storeStep3')->name('my-transactions.store-step3');
    Route::get('/my-transactions/{id}', 'Web\MyTransaction\MyTransactionController@show')->name('my-transactions.show');

    //payment controller
	Route::get('/my-payments', 'Web\MyPayments\MyPaymentController@index')->name('my-payments.index');
	Route::get('/my-payments/create', 'Web\MyPayments\MyPaymentController@create')->name('my-payments.create');
	Route::post('/my-payments/store', 'Web\MyPayments\MyPaymentController@store')->name('my-payments.store');

    // transaction request routes
    Route::get('/transaction-requests', 'Web\MyTransaction\TransactionRequestController@index')->name('transaction-requests.index');
    Route::get('/transaction-requests/accept/{token}', 'Web\MyTransaction\TransactionRequestController@accept')->name('transaction-requests.accept');

	// deposit controller route
    Route::get('/my-account/deposit', 'Web\Deposits\DepositController@create')->name('my-account.deposit.create');

    // my account routes
	Route::get('/my-account/balance', 'Web\MyAccount\MyAccountController@balance')->name('my-account.balance');


	//TRANSFER FUNDS ROUTES

	Route::get('/my-account/transferfund', 'Web\Transfer\TransferController@create')->name('my-account.transferfund.create');
    // payment routes
    Route::get('/my-payments', 'Web\MyPayments\MyPaymentController@index')->name('my-payments.index');
    Route::get('/my-payments/create', 'Web\MyPayments\MyPaymentController@create')->name('my-payments.create');
    Route::post('/my-payments/store', 'Web\MyPayments\MyPaymentController@store')->name('my-payments.store');
    Route::get('/my-payments/{id}', 'Web\MyPayments\MyPaymentController@show')->name('my-payments.show');

	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	// orders routes...
	Route::get('/orders/addItemToCart', 'Web\Order\OrderController@addItemToCart')->name('orders.addItemToCart');

    // Route::resource('/admin/orders', 'Web\Admin\Order\OrderController');

	// companyjoinrequests routes...
	Route::resource('/company-join-requests', 'Web\Company\CompanyJoinRequestController');
	Route::get('/company-join-requests/{id}/process', 'Web\Company\CompanyJoinRequestController@showProcessJoinRequest')->name('company-join-requests.createprocess');
	Route::post('/company-join-requests/process', 'Web\Company\CompanyJoinRequestController@processJoinRequest')->name('company-join-requests.process');

	// loan applications routes...
	Route::get('/my-account', 'Web\HomeController@account')->name('my-account');

	// Route::get('/my-account', 'Web\HomeController@index')->name('my-account');
	Route::get('/changepass', 'Web\HomeController@index')->name('changepass');

	// user profile routes...
	Route::get('/profile/change-password', 'ProfileController@changepass')->name('user.changepass');
	Route::post('/profile/change-password', 'ProfileController@changepassStore')->name('user.changepass.store');
	Route::get('/profile', 'ProfileController@index')->name('user.profile');

	// image upload / resize routes
	Route::get('/resizeImage', 'Web\Images\ImageController@resizeImage')->name('images.index');
	Route::post('/resizeImagePost', 'Web\Images\ImageController@resizeImagePost')->name('images.store');

});

// superadmin routes
Route::group(['middleware' => 'role:superadministrator'], function () {

	//permission routes...
	Route::resource('/permissions', 'PermissionController', ['except' => 'destroy']);

	//mpesa paybills routes
	Route::resource('/mpesa-paybills', 'MpesaPaybillController');

	//manage products routes...
	Route::resource('/admin/products', 'Web\Admin\Product\ProductController', [
		'as' => 'admin'
	]);

	//manage glaccounts routes...
	Route::resource('/manage/glaccounts', 'Web\GlAccount\GlAccountController');

});

// superadmin and admin routes
Route::group(['middleware' => 'role:superadministrator|administrator'], function() {

	// establishments routes...
	// Route::resource('/establishments', 'EstablishmentController');
	Route::resource('/admin/establishments', 'Web\Admin\Company\EstablishmentController', ['names' => [
		'index' => 'admin.establishments.index',
		'create' => 'admin.establishments.create',
		'store' => 'admin.establishments.store',
		'edit' => 'admin.establishments.edit',
		'update' => 'admin.establishments.update',
		'show' => 'admin.establishments.show',
		'destroy' => 'admin.establishments.destroy'
    ]]);

    // orders
    Route::resource('/admin/orders', 'Web\Admin\Order\OrderController', ['names' => [
		'index' => 'admin.orders.index',
		'create' => 'admin.orders.create',
		'store' => 'admin.orders.store',
		'edit' => 'admin.orders.edit',
		'update' => 'admin.orders.update',
		'show' => 'admin.orders.show',
		'destroy' => 'admin.orders.destroy'
    ]]);

    // tills
    Route::get('/admin/tills/{id}/confirm', 'Web\Admin\Till\TillController@confirmTillCreate')->name('admin.tills.confirm-till-create');
    Route::post('/admin/tills/confirmTillStore', 'Web\Admin\Till\TillController@confirmTillStore')->name('admin.tills.confirm-till-store');
	Route::resource('/admin/tills', 'Web\Admin\Till\TillController', ['names' => [
		'index' => 'admin.tills.index',
		'create' => 'admin.tills.create',
		'store' => 'admin.tills.store',
		'edit' => 'admin.tills.edit',
		'update' => 'admin.tills.update',
		'show' => 'admin.tills.show',
		'destroy' => 'admin.tills.destroy'
    ]]);


	// user routes...
	Route::resource('/admin/users', 'Web\Admin\User\UserController');

	/* ADMIN ROUTES */
	Route::get('/admin', 'Web\Admin\AdminHomeController@index')->name('admin.home');

	// handle bulk import user...
	Route::get('/admin/users/create-bulk', 'Web\Admin\UserImportController@create')->name('bulk-users.create');
	Route::post('/admin/users/create-bulk', 'Web\Admin\UserImportController@store')->name('bulk-users.store');
	Route::get('/admin/users/create-bulk/get-data/{uuid}', 'Web\Admin\UserImportController@getImportData')->name('bulk-users.getimportdata');
	Route::get('/admin/users/create-bulk/get-incomplete/{uuid}', 'Web\Admin\UserImportController@getIncompleteData')->name('bulk-users.getincompletedata');

	// send email routes...
	Route::get('/admin/email/newUser', 'EmailController@newUserEmail')->name('email.newuser');

	// offers routes...
	// Route::resource('/admin/offers', 'Web\Admin\Offer\OfferController');

    Route::get('/admin/offers/{offer_id}/add-products', 'Web\Admin\OfferProduct\OfferProductController@createOfferProducts')->name('admin.offers.add-products.create');
    Route::post('/admin/offers/{offer_id}/add-products', 'Web\Admin\OfferProduct\OfferProductController@storeOfferProducts')->name('admin.offers.add-products.store');
	Route::resource('/admin/offers', 'Web\Admin\Offer\OfferController', ['names' => [
		'index' => 'admin.offers.index',
		'create' => 'admin.offers.create',
		'store' => 'admin.offers.store',
		'edit' => 'admin.offers.edit',
		'update' => 'admin.offers.update',
		'show' => 'admin.offers.show',
		'destroy' => 'admin.offers.destroy'
    ]]);

	Route::resource('/admin/offerproducts', 'Web\Admin\OfferProduct\OfferProductController', ['names' => [
		'index' => 'admin.offerproducts.index',
		'create' => 'admin.offerproducts.create',
		'store' => 'admin.offerproducts.store',
		'edit' => 'admin.offerproducts.edit',
		'update' => 'admin.offerproducts.update',
		'show' => 'admin.offerproducts.show',
		'destroy' => 'admin.offerproducts.destroy'
    ]]);

	Route::resource('/admin/companyproducts', 'Web\Admin\CompanyProduct\CompanyProductController', ['names' => [
		'index' => 'admin.companyproducts.index',
		'create' => 'admin.companyproducts.create',
		'store' => 'admin.companyproducts.store',
		'edit' => 'admin.companyproducts.edit',
		'update' => 'admin.companyproducts.update',
		'show' => 'admin.companyproducts.show',
		'destroy' => 'admin.companyproducts.destroy'
	]]);

	//manage assets routes...
	Route::resource('/manage/assets', 'Web\Assets\AssetController');

	//manage company  ranches routes...
	Route::resource('/companybranches', 'Web\CompanyBranch\CompanyBranchController');

	//manage events routes...
	Route::resource('/manage/events', 'Web\Events\EventController');

	//manage loansettings routes...
	Route::resource('/manage/loansettings', 'Web\Manage\Setting\LoanSettingController');

	//manage remindersettings routes...
	Route::resource('/manage/remindersettings', 'Web\Manage\Setting\ReminderMessageSettingController');

	//role routes...
	Route::resource('/roles', 'RoleController', ['except' => 'destroy']);

	//group routes...
	Route::resource('/groups', 'GroupController');

	//branch group routes...
	Route::resource('/branchgroups', 'Web\BranchGroup\BranchGroupController');

	//branch group members routes...
	Route::resource('/groupmembers', 'Web\GroupMember\GroupMemberController');

	Route::get('groupmembers', 'Web\GroupMember\GroupMemberController@index')->name('groupmembers.index');
	Route::get('groupmembers/new/create-step-1', 'Web\GroupMember\GroupMemberController@create_step1')->name('groupmembers.create-step1');
	Route::post('groupmembers/new/create-step-1', 'Web\GroupMember\GroupMemberController@create_step1_store')->name('groupmembers.create-step1-store');
	Route::get('groupmembers/new/create-step-2', 'Web\GroupMember\GroupMemberController@create_step2')->name('groupmembers.create-step2');
	Route::post('groupmembers/new/create-step-2', 'Web\GroupMember\GroupMemberController@create_step2_store')->name('groupmembers.create-step2-store');
	Route::get('groupmembers/{id}/edit', 'Web\GroupMember\GroupMemberController@edit')->name('groupmembers.edit');
	Route::post('groupmembers', 'Web\GroupMember\GroupMemberController@store')->name('groupmembers.store');
	Route::put('groupmembers/{id}/update', 'Web\GroupMember\GroupMemberController@update')->name('groupmembers.update');
	Route::patch('groupmembers/{id}/update', 'Web\GroupMember\GroupMemberController@update')->name('groupmembers.update');
	Route::get('groupmembers/{id}', 'Web\GroupMember\GroupMemberController@show')->name('groupmembers.show');

	//branch members routes...
	Route::resource('/branchmembers', 'Web\BranchMember\BranchMemberController');

	//cash transfers routes...
	Route::get('/transfers/create-step-2', 'Web\Transfer\TransferController@create_step2')->name('transfers.create_step2');
	Route::get('/transfers/create-step-3', 'Web\Transfer\TransferController@create_step3')->name('transfers.create_step3');
	Route::resource('/transfers', 'Web\Transfer\TransferController');

	//my account routes...
	Route::get('/myaccount/mpesab2cbalance', 'Web\MyAccount\MyAccountController@getmpesab2cbalance')->name('myaccount.mpesab2cbalance');

    //mpesa-incoming routes...
    Route::resource('/mpesa-incoming', 'MpesaIncomingController');

    //payments routes...
	Route::get('/payments',
			'Web\Payment\PaymentController@index')->name('payments.index');
	Route::get('/payments/{id}',
			'Web\Payment\PaymentController@show')->name('payments.show');
	Route::get('/payments/{id}/edit',
			'Web\Payment\PaymentController@edit')->name('payments.edit');
	Route::put('/payments/{id}/update',
			'Web\Payment\PaymentController@update')->name('payments.update');
	Route::get('/payments/{id}/repost',
			'Web\Payment\PaymentController@repost')->name('payments.repost');

    //ussd-registration routes...
    Route::resource('/ussd-registration', 'Web\Ussd\UssdRegistrationController', ['except' => 'destroy']);

    //ussd-events routes...
    Route::resource('/ussd-events', 'Web\Ussd\UssdEventController', ['except' => 'destroy']);

    //ussd-payments routes...
    Route::resource('/ussd-payments', 'Web\Ussd\UssdPaymentController', ['except' => ['edit', 'update', 'destroy']]);

    //ussd-recommends routes...
    Route::resource('/ussd-recommends', 'Web\Ussd\UssdRecommendController', ['except' => ['edit', 'update', 'destroy']]);

    //ussd-contactus routes...
    Route::resource('/ussd-contactus', 'Web\Ussd\UssdContactUsController', ['except' => ['edit', 'update', 'destroy']]);

	//smsoutbox routes...
	Route::resource('/smsoutbox', 'SmsOutboxController', ['except' => ['edit', 'destroy']]);

	//schedule smsoutbox routes...
	Route::resource('/scheduled-smsoutbox', 'ScheduleSmsOutboxController');

	//shares account history routes...
	Route::resource('/shares-accounts-history', 'Web\Account\SharesAccountHistoryController', ['except' => ['edit', 'destroy']]);

	//shares account summary routes...
	Route::resource('/shares-accounts-summary', 'Web\Account\SharesAccountSummaryController', ['except' => ['edit', 'destroy']]);

	//deposit account history routes...
	Route::resource('/deposit-accounts-history', 'Web\Account\DepositAccountHistoryController', ['except' => ['edit', 'destroy']]);

	//deposit account summary routes...
	Route::resource('/deposit-accounts-summary', 'Web\Account\DepositAccountSummaryController', ['except' => ['edit', 'destroy']]);

	//Gl account history routes...
	Route::resource('/gl-accounts-history', 'Web\Account\GlAccountHistoryController', ['except' => ['edit', 'destroy']]);

	//Gl account summary routes...
	Route::resource('/gl-accounts-summary', 'Web\Account\GlAccountSummaryController', ['except' => ['edit', 'destroy']]);

	//Assets routes...
	Route::resource('/assets', 'Web\Asset\AssetController', ['except' => ['destroy']]);

	//savings deposit accounts routes...
	Route::resource('/savings-deposit-accounts', 'Web\Account\SavingsDepositAccountController');

});

Route::group(['middleware' => 'guest'], function() {

	// guest - no login required here
	// logged in users will be redirected
	// Authentication Routes...
	Route::get('auth/login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('auth/login', 'Auth\LoginController@login')->name('login.store');

	Route::get('auth/confirm', 'Auth\LoginController@showConfirmForm')->name('confirm');
	Route::post('auth/confirm', 'Auth\LoginController@confirm')->name('confirm.store');

	/* Route::get('resend-code', 'Auth\LoginController@showResendCodeForm')->name('resend_code');
	Route::post('resend-code', 'Auth\LoginController@resendCode')->name('resend_code.store'); */

	Route::get('auth/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('auth/register', 'Auth\RegisterController@store')->name('register.store');
    Route::post('auth/registerUser', 'Auth\RegisterController@storeUser')->name('register.storeUser');

	Route::get('auth/activate-account', 'Auth\ActivateAccountController@showActivationForm')->name('activate-account');
    Route::post('auth/activate-account', 'Auth\ActivateAccountController@store')->name('activate-account.store');
    Route::get('auth/resend-activation-code', 'Auth\ActivateAccountController@showResendActivationCodeForm')->name('resend-activation-code');
	Route::post('auth/resend-activation-code', 'Auth\ActivateAccountController@resendStore')->name('resend-activation-code.store');

	// Password Reset Routes...
	Route::post('auth/password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.store');
	Route::get('auth/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

	Route::post('auth/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('auth/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

});
