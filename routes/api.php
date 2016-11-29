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

    $router->post('search/all', 'Api\SearchController@all');

    $router->get('clients/list', 'Api\ClientsController@lists');
    $router->get('clients/history/{id}', 'Api\ClientsController@history');
    $router->resource('clients', 'Api\ClientsController');

    $router->get('sites/list', 'Api\SitesController@lists');
    $router->get('sites/history/{id}', 'Api\SitesController@history');
    $router->resource('sites', 'Api\SitesController');

    $router->resource('accounts', 'Api\AccountsController');

});
