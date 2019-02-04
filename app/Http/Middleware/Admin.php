<?php

namespace App\Http\Middleware;

use Closure;
use App\Service\LoginService;
use App\Repositories\UserRepository;
use App\Services\Token\LoginTokenContract;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	if (LoginService::check() && LoginService::getLoggedInUser()->isAdmin()) {
            return $next($request);
        }
       abort(403);
    }
}
