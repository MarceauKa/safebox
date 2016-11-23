<?php

use Illuminate\Http\Request;

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

Route::group([
    'middleware' => ['auth:api']
], function (\Illuminate\Routing\Router $router) {

    $router->get('user', function (Request $request) {
        return $request->user();
    });

    $router->get('clients/list', 'Api\ClientsController@lists');
    $router->resource('clients', 'Api\ClientsController');

    $router->resource('sites/list', 'Api\SitesController@lists');
    $router->resource('sites', 'Api\SitesController');

    $router->resource('accounts', 'Api\AccountsController');

});
