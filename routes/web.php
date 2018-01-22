<?php


Route::get('/', ['as' => 'home', 'uses' => 'MainController@index']);
Route::post('/contact', ['as' => 'contact.post', 'uses' => 'MainController@contact_post']);
Route::get('/conditions-generales-de-ventes', ['as' => 'cgv', 'uses' => 'MainController@cgv']);
Route::get('/mentions-legales', ['as' => 'mentions', 'uses' => 'MainController@mentions']);
Route::get('/realisations', ['as' => 'realisations', 'uses' => 'MainController@realisations']);

//Redirection permanente
Route::get('/home', ['uses' => 'MainController@redirectHome']);