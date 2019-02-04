<?php

namespace App\Providers;

use App\Models\User;
use Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\StoreRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    	//
    }
}
