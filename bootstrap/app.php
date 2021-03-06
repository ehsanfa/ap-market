<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\StoreRepository;
use App\Repositories\ProductRepository;
use App\Services\Token\JwtTokenGenerator;
use App\Services\Token\LoginTokenContract;

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(dirname(__DIR__)))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->bind(UserRepository::class, function ($app) {
	return new UserRepository(User::class);
});

$app->bind(StoreRepository::class, function ($app) {
	return new StoreRepository(Store::class);
});

$app->bind(OrderRepository::class, function ($app) {
	return new OrderRepository(Order::class);
});

$app->bind(ProductRepository::class, function ($app) {
	return new ProductRepository(Product::class);
});

$app->bind(
	LoginTokenContract::class,
	JwtTokenGenerator::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'admin' => App\Http\Middleware\Admin::class,
    'customer' => App\Http\Middleware\Customer::class,
    'guest' => App\Http\Middleware\Guest::class,
    'seller' => App\Http\Middleware\Seller::class,
    'token' => App\Http\Middleware\CheckToken::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
