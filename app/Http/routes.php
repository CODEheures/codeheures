<?php


Route::get('/', ['as' => 'home', 'uses' => 'MainController@index']);
Route::post('/contact', ['as' => 'contact.post', 'uses' => 'MainController@contact_post']);
Route::get('/demo', ['as' => 'demo', 'uses' => 'MainController@demoCustomerSpace']);
Route::get('/conditions-generales-de-ventes', ['as' => 'cgv', 'uses' => 'MainController@cgv']);
Route::get('/mentions-legales', ['as' => 'mentions', 'uses' => 'MainController@mentions']);

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
    
    //customer monitor index
    Route::get('/monitor', ['as' => 'customer.monitor.index', 'uses' => 'CustomerController@monitor']);

    //customer quotations
    Route::get('/quotation', ['as' => 'customer.quotation.index', 'uses' => 'QuotationController@customerIndex']);
    Route::get('/quotation/{id}/order', ['as' => 'customer.quotation.order', 'uses' => 'QuotationController@order'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/refuse', ['as' => 'customer.quotation.refuse', 'uses' => 'QuotationController@refuse'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/pdf', ['as' => 'customer.quotation.pdf', 'uses' => 'QuotationController@pdf'])->where(['id'=>'[0-9]+']);
    Route::post('/quotation/{id}/order', ['as' => 'customer.quotation.order.post', 'uses' => 'QuotationController@orderPost'])->where(['id'=>'[0-9]+']);

    //customer prestations
    Route::get('/prestation/pdf', ['as' => 'customer.prestation.pdf', 'uses' => 'PrestationController@pdf']);
});

//Espace admin
Route::group(['prefix' => 'admin'], function() {
    //admin monitor index
    Route::get('/monitor', ['as' => 'admin.monitor.index', 'uses' => 'AdminController@monitor']);

    //consommations
    Route::post('/consommation', ['as' => 'admin.consommation.store', 'uses' => 'ConsommationController@store']);
    Route::get('/consommation/{id}/delete', ['as' => 'admin.consommation.delete', 'uses' => 'ConsommationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::delete('/consommation/{id}', ['as' => 'admin.consommation.destroy', 'uses' => 'ConsommationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::get('/consommation/{id}/edit', ['as' => 'admin.consommation.edit', 'uses' => 'ConsommationController@edit'])->where(['id'=>'[0-9]+']);
    Route::put('/consommation/{id}', ['as' => 'admin.consommation.update', 'uses' => 'ConsommationController@update'])->where(['id'=>'[0-9]+']);

    //quotations
    Route::get('/quotation', ['as' => 'admin.quotation.index', 'uses' => 'QuotationController@index']);
    Route::post('/quotation', ['as' => 'admin.quotation.store', 'uses' => 'QuotationController@store']);
    Route::get('/quotation/{id}/delete', ['as' => 'admin.quotation.delete', 'uses' => 'QuotationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::delete('/quotation/{id}', ['as' => 'admin.quotation.destroy', 'uses' => 'QuotationController@destroy'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/create', ['as' => 'admin.quotation.create', 'uses' => 'QuotationController@create']);
    Route::get('/quotation/{id}/edit/{lineQuoteId?}', ['as' => 'admin.quotation.edit', 'uses' => 'QuotationController@edit'])->where(['id'=>'[0-9]+', 'lineQuoteId'=>'[0-9]+']);
    Route::put('/quotation/{id}', ['as' => 'admin.quotation.update', 'uses' => 'QuotationController@update'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/publish', ['as' => 'admin.quotation.publish', 'uses' => 'QuotationController@publish'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/unPublish', ['as' => 'admin.quotation.unPublish', 'uses' => 'QuotationController@unPublish'])->where(['id'=>'[0-9]+']);
    Route::get('/quotation/{id}/archive', ['as' => 'admin.quotation.archive', 'uses' => 'QuotationController@archive'])->where(['id'=>'[0-9]+']);

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
    //test sms
    Route::get('/sms', 'AdminController@sms');

    //reset DemoUser
    Route::get('/resetDemo', 'AdminController@resetDemo');
});

//Purchases routes
Route::group(['prefix' => 'purchase'], function() {
   Route::get('/{id}', ['as' => 'purchase.show', 'uses' => 'PurchaseController@show'])
       ->where(['id'=>'[0-9]+']);
});

// Authentication routes...
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function() {

    //login routes
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    // Registration routes...
    Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'AuthController@postRegister']);

    //Account confirmation
    Route::get('account-confirm/{id}/{token}', ['as' => 'account.confirm', 'uses' => 'AuthController@accountConfirm']);
});

// Password reset link request routes...
Route::group(['prefix' => 'password', 'namespace' => 'Auth'], function(){
    Route::get('email', ['as' => 'reset.request', 'uses' => 'PasswordController@getEmail']);
    Route::post('email', ['as' => 'reset.post', 'uses' => 'PasswordController@postEmail']);

    // Password reset routes...
    Route::get('reset/{token}', ['as' => 'reset.email', 'uses' => 'PasswordController@getReset']);
    Route::post('reset', ['as' => 'reset.finish', 'uses' => 'PasswordController@postReset']);
});

//Redirection permanente
Route::get('/home', function(){
    return redirect(url('/'),301);
});

//Tests Routes
Route::group(['prefix' => 'test', 'namespace' => 'Test'], function() {
    Route::get('email', 'TestController@testMail');

});