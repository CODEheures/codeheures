<?php


Route::get('/', ['as' => 'home', 'uses' => 'MainController@index']);
Route::post('/contact', ['as' => 'contact.post', 'uses' => 'MainController@contact_post']);
Route::get('/demo', ['as' => 'demo', 'uses' => 'MainController@demoCustomerSpace']);
Route::get('/conditions-generales-de-ventes', ['as' => 'cgv', 'uses' => 'MainController@cgv']);
Route::get('/mentions-legales', ['as' => 'mentions', 'uses' => 'MainController@mentions']);
Route::get('/realisations', ['as' => 'realisations', 'uses' => 'MainController@realisations']);
Route::get('/cqa/{hashName}', ['as' => 'customer.quotation.attachment', 'uses' => 'QuotationController@getAttachment'])->where(['hashName'=>'[a-zA-Z0-9]{32}']);

//Espace client
Route::group(['prefix' => 'customer'], function() {
    //customer account index
    Route::get('/account', ['as' => 'customer.account.edit', 'uses' => 'CustomerController@edit']);
    Route::put('account', ['as' => 'customer.account.update', 'uses' => 'CustomerController@update']);
    Route::put('account/address', ['as' => 'customer.account.addressUpdate', 'uses' => 'CustomerController@addressUpdate']);
    Route::post('account/phone', ['as' => 'customer.account.phone.update', 'uses' => 'CustomerController@updatePhoneOnly']);
    Route::get('/register', ['as' => 'customer.demoToRegister', 'uses' => 'CustomerController@customerDemoToRegister']);
    //customer sale
    Route::get('/sale/choice', ['as' => 'customer.sale.choice', 'uses' => 'CustomerController@saleChoice']);
    Route::post('/sale/recapitulation', ['as' => 'customer.sale.recapitulation', 'uses' => 'CustomerController@saleRecapitulation']);
    Route::get('/sale/payment/{id}', ['as' => 'customer.sale.payment', 'uses' => 'CustomerController@salePayment'])->where(['id'=>'[0-9]+']);
    Route::get('/sale/payment/status', ['as' => 'customer.sale.payment.status', 'uses' => 'CustomerController@salePaymentStatus']);

    //customer monitor index
    Route::get('/monitor', ['as' => 'customer.monitor.index', 'uses' => 'CustomerController@monitor']);

    //customer quotations
    Route::get('/quotation', ['as' => 'customer.quotation.index', 'uses' => 'QuotationController@customerIndex']);
    Route::get('/quotation/{id}/order', ['as' => 'customer.quotation.order', 'uses' => 'QuotationController@order'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/refuse', ['as' => 'customer.quotation.refuse', 'uses' => 'QuotationController@refuse'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}', ['as' => 'customer.quotation.showPdf', 'uses' => 'QuotationController@showPdf'])->where(['id'=>'[0-9]+']);
    Route::post('/quotation/{id}/order', ['as' => 'customer.quotation.order.post', 'uses' => 'QuotationController@orderPost'])->where(['id'=>'[0-9]+']);

    //customer prestations
    Route::get('/prestations/pdf', ['as' => 'customer.prestation.pdf', 'uses' => 'PrestationController@pdf']);

    //customer prestations
    Route::get('/test/pdf', ['as' => 'test.pdf', 'uses' => 'CustomerController@testPdf']);
});

//Espace admin
Route::group(['prefix' => 'admin'], function() {
    //admin monitor index
    Route::get('/monitor', ['as' => 'admin.monitor.index', 'uses' => 'AdminController@monitor']);

    //admin customer manage
    Route::get('/customer/active/{id}', ['as' => 'admin.customer.active', 'uses' => 'AdminController@customerActive'])->where(['id'=>'[0-9]+']);
    Route::get('/customer/desactive/{id}', ['as' => 'admin.customer.desactive', 'uses' => 'AdminController@customerDesactive'])->where(['id'=>'[0-9]+']);
    Route::put('/customer/updateQuota/{id}', ['as' => 'admin.customer.updateQuota', 'uses' => 'AdminController@updateCustomerQuota'])->where(['id'=>'[0-9]+']);

    Route::get('/customer/register', 'AdminController@customerRegisterView')->name('admin.customer.create');
    Route::post('/customer/register', 'AdminController@customerRegisterPost')->name('admin.customer.register');
    Route::get('/customer/edit/{id}', 'AdminController@customerEditView')->name('admin.customer.edit');
    Route::put('/customer/edit/{id}', 'AdminController@customerUpdate')->name('admin.customer.update');

    //consommations
    Route::post('/consommation', ['as' => 'admin.consommation.store', 'uses' => 'ConsommationController@store']);
    Route::get('/consommation/{id}/delete', ['as' => 'admin.consommation.delete', 'uses' => 'ConsommationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::delete('/consommation/{id}', ['as' => 'admin.consommation.destroy', 'uses' => 'ConsommationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::get('/consommation/{id}/edit', ['as' => 'admin.consommation.edit', 'uses' => 'ConsommationController@edit'])->where(['id'=>'[0-9]+']);
    Route::put('/consommation/{id}', ['as' => 'admin.consommation.update', 'uses' => 'ConsommationController@update'])->where(['id'=>'[0-9]+']);

    //quotations
    Route::get('/quotation', ['as' => 'admin.quotation.index', 'uses' => 'QuotationController@index']);
    Route::post('/quotation', ['as' => 'admin.quotation.store', 'uses' => 'QuotationController@store']);
    Route::get('/quotation/{id}/cancel', ['as' => 'admin.quotation.cancel', 'uses' => 'QuotationController@cancel'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/delete', ['as' => 'admin.quotation.delete', 'uses' => 'QuotationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::delete('/quotation/{id}', ['as' => 'admin.quotation.destroy', 'uses' => 'QuotationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/create', ['as' => 'admin.quotation.create', 'uses' => 'QuotationController@create']);
    Route::get('/quotation/{id}/edit/{lineQuoteId?}', ['as' => 'admin.quotation.edit', 'uses' => 'QuotationController@edit'])->where(['id'=>'[0-9]+', 'lineQuoteId'=>'[0-9]+']);
    Route::put('/quotation/{id}', ['as' => 'admin.quotation.update', 'uses' => 'QuotationController@update'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/publish', ['as' => 'admin.quotation.publish', 'uses' => 'QuotationController@publish'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/unPublish', ['as' => 'admin.quotation.unPublish', 'uses' => 'QuotationController@unPublish'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/archive', ['as' => 'admin.quotation.archive', 'uses' => 'QuotationController@archive'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/invoice/create/{type}/{percent}/{intermediateNumber?}', ['as' => 'admin.quotation.invoice.create', 'uses' => 'QuotationController@invoiceCreate'])
        ->where(['id'=>'[0-9]+'])->where(['type' => '\b(isDown|isSold|isIntermediate)\b'])->where(['percent'=>'[0-9]{1,3}'])->where(['intermediateNumber'=>'[0-9]+']);

    //lineQuotes
    Route::post('/lineQuote', ['as' => 'admin.lineQuote.store', 'uses' => 'LineQuoteController@store']);
    Route::get('/lineQuote/{id}/delete', ['as' => 'admin.lineQuote.delete', 'uses' => 'LineQuoteController@destroy'])->where(['id'=>'[0-9]+']);
    Route::delete('/lineQuote/{id}', ['as' => 'admin.lineQuote.destroy', 'uses' => 'LineQuoteController@destroy'])->where(['id'=>'[0-9]+']);
    Route::get('/lineQuote/{id}/edit', ['as' => 'admin.lineQuote.edit', 'uses' => 'LineQuoteController@edit'])->where(['id'=>'[0-9]+']);
    Route::put('/lineQuote/{id}', ['as' => 'admin.lineQuote.update', 'uses' => 'LineQuoteController@update'])->where(['id'=>'[0-9]+']);

    //products
    Route::get('/product', ['as' => 'admin.product.index', 'uses' => 'ProductController@index']);
    Route::get('/product/{id}/edit', ['as' => 'admin.product.edit', 'uses' => 'ProductController@edit'])->where(['id'=>'[0-9]+']);
    Route::post('/product', ['as' => 'admin.product.store', 'uses' => 'ProductController@store']);
    Route::get('/product/{id}/delete', ['as' => 'admin.product.delete', 'uses' => 'ProductController@destroy'])->where(['id'=>'[0-9]+']);
    Route::delete('/product/{id}', ['as' => 'admin.product.destroy', 'uses' => 'ProductController@destroy'])->where(['id'=>'[0-9]+']);
    Route::get('/product/create', ['as' => 'admin.product.create', 'uses' => 'ProductController@create']);
    Route::put('/product/{id}', ['as' => 'admin.product.update', 'uses' => 'ProductController@update'])->where(['id'=>'[0-9]+']);
    Route::get('/product/{id}/toObsolete', ['as' => 'admin.product.toObsolete', 'uses' => 'ProductController@toObsolete'])->where(['id'=>'[0-9]+']);
    Route::get('/product/{id}/toNotObsolete', ['as' => 'admin.product.toNotObsolete', 'uses' => 'ProductController@toNotObsolete'])->where(['id'=>'[0-9]+']);

    //prestations
    Route::get('/prestation', ['as' => 'admin.prestation.index', 'uses' => 'PrestationController@index']);
    Route::get('/prestation/{id}/edit', ['as' => 'admin.prestation.edit', 'uses' => 'PrestationController@edit'])->where(['id'=>'[0-9]+']);
    Route::post('/prestation', ['as' => 'admin.prestation.store', 'uses' => 'PrestationController@store']);
    Route::get('/prestation/{id}/delete', ['as' => 'admin.prestation.delete', 'uses' => 'PrestationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::delete('/prestation/{id}', ['as' => 'admin.prestation.destroy', 'uses' => 'PrestationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::get('/prestation/create', ['as' => 'admin.prestation.create', 'uses' => 'PrestationController@create']);
    Route::put('/prestation/{id}', ['as' => 'admin.prestation.update', 'uses' => 'PrestationController@update'])->where(['id'=>'[0-9]+']);
    Route::get('/prestation/{id}/publish', ['as' => 'admin.prestation.publish', 'uses' => 'PrestationController@publish'])->where(['id'=>'[0-9]+']);
    Route::get('/prestation/{id}/toObsolete', ['as' => 'admin.prestation.toObsolete', 'uses' => 'PrestationController@toObsolete'])->where(['id'=>'[0-9]+']);
    Route::get('/prestation/{id}/toNotObsolete', ['as' => 'admin.prestation.toNotObsolete', 'uses' => 'PrestationController@toNotObsolete'])->where(['id'=>'[0-9]+']);
    Route::get('/prestation/{id}', ['as' => 'admin.prestation.show', 'uses' => 'PrestationController@show'])->where(['id'=>'[0-9]+']);

    //reset DemoUser
    Route::get('/resetDemo', ['as' => 'admin.resetDemo', 'uses'=>'AdminController@resetDemo']);
});

//Purchases routes
Route::group(['prefix' => 'purchase'], function() {
    Route::get('/{id}', ['as' => 'purchase.show', 'uses' => 'PurchaseController@show'])
        ->where(['id'=>'[0-9]+']);
});

//Invoice routes
Route::group(['prefix' => 'invoice'], function () {
    Route::get('/{type}/{origin}/{origin_id}/{intermediateNumber?}', ['as' => 'invoice.get', 'uses' => 'InvoiceController@get'])
        ->where(['type' => '\b(isDown|isSold|isIntermediate)\b'])->where(['origin' => '\b(quotation|purchase)\b'])->where(['origin_id'=>'[0-9]+'])->where(['intermediateNumber'=>'[0-9]+']);
    Route::get('/sendMail/{type}/{origin}/{origin_id}/{intermediateNumber?}', ['as' => 'invoice.sendMail', 'uses' => 'InvoiceController@sendMail'])
        ->where(['type' => '\b(isDown|isSold|isIntermediate)\b'])->where(['origin' => '\b(quotation|purchase)\b'])->where(['origin_id'=>'[0-9]+'])->where(['intermediateNumber'=>'[0-9]+']);
    Route::get('/validatePayment/{type}/{origin}/{origin_id}/{intermediateNumber?}', ['as' => 'invoice.validatePayment', 'uses' => 'InvoiceController@validatePayment'])
        ->where(['type' => '\b(isDown|isSold|isIntermediate)\b'])->where(['origin' => '\b(quotation|purchase)\b'])->where(['origin_id'=>'[0-9]+'])->where(['intermediateNumber'=>'[0-9]+']);
});

// Authentication routes...
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function() {

    //login routes
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login.post');
    Route::post('logout', 'LoginController@logout')->name('logout');


    // Registration routes...
    Route::group(['prefix' => 'register'], function() {
        Route::get('/', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('/', 'RegisterController@register')->name('register.post');
    });


    //Oauth Routes
    Route::get('social/{provider}', ['as' => 'social.login', 'uses' => 'SocialiteController@redirectToProvider'])
        ->where(['provider'=>'[a-zA-Z]+']);
    Route::get('social/callback/{provider}', ['as' => 'social.callback', 'uses' => 'SocialiteController@handleProviderCallback'])
        ->where(['provider'=>'[a-zA-Z]+']);

    //Account confirmation
    Route::get('account-confirm/{id}/{token}', ['as' => 'account.confirm', 'uses' => 'RegisterController@accountConfirm']);

    //Process type 2 (confirm->force new password -> view quotation id)
    Route::get('/process2/account-confirm/{userId}/{token}', ['as' => 'process2.accountConfirm', 'uses' => 'RegisterController@accountConfirmTwo'])->where(['userId'=>'[0-9]+']);

    //Email resend confirmation
    Route::get('email/resendToken', ['as' => 'email.resendToken', 'uses' => 'RegisterController@resendToken']);
});

// Password reset link request routes...
Route::group(['prefix' => 'password', 'namespace' => 'Auth'], function(){
    Route::get('/reset', 'ForgotPasswordController@showLinkRequestForm')->name('reset.request');
    Route::post('/email', 'ForgotPasswordController@sendResetLinkEmail')->name('reset.post');
    Route::get('/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/reset', 'ResetPasswordController@reset')->name('reset.finish');
    Route::post('/process2/reset', 'ResetPasswordController@resetTwo')->name('process2.reset.finish');
});

//Redirection permanente
Route::get('/home', ['uses' => 'MainController@redirectHome']);

//Tests Routes
Route::group(['prefix' => 'test'], function() {
    Route::get('email', 'TestController@testMail');
    Route::get('sms', 'AdminController@sms');
});