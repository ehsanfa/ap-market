<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['middleware' => 'guest'], function ($router) {
	$router->group(['prefix' => 'auth'], function ($router) {
		$router->post('login', 'AuthController@login');
		$router->post('register', 'AuthController@register');
	});
});

$router->group(['middleware' => 'token'], function ($router) {
	$router->group(['prefix' => 'sellers'], function ($router) {
		$router->post('/', [
			'uses' => 'SellerController@store',
			'middleware' => 'admin'
		]);
	});
	$router->group(['prefix' => 'stores'], function ($router) {
		$router->get('/', 'StoreController@index');
		$router->post('/', [
			'uses' => 'StoreController@store',
			'middleware' => 'seller'
		]);
		$router->group(['prefix' => '{storeId}/products'], function ($router) {
			$router->get('/',  'ProductController@index');
			$router->post('/', [
				'uses' => 'ProductController@store',
				'middleware' => 'seller'
			]);
			$router->post('/{productId}/order', [
				'uses' => 'OrderController@store',
				'middleware' => 'customer'
			]);
		});
	});
	$router->post('/checkout', [
		'uses' => 'CheckoutController@checkout',
		'middleware' => 'customer'
	]);
});
