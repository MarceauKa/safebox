<?php

Route::get('/', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::get('logout/{csrf}', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::post('password/email', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', ['uses' => 'Auth\ResetPasswordController@reset']);
Route::get('password/reset/{token}', ['uses' => 'Auth\ResetPasswordController@showResetForm']);

Route::get('home', 'HomeController@index');

Route::group([
    'prefix' => 'backend',
    'as' => 'backend.',
    'middleware' => ['auth'],
], function(\Illuminate\Routing\Router $router) {

    $router->get('clients', ['as' => 'clients', 'uses' => 'ClientsController@index']);
    $router->get('sites', ['as' => 'sites', 'uses' => 'SitesController@index']);
    $router->get('accounts', ['as' => 'accounts', 'uses' => 'AccountsController@index']);

});
