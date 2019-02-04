<?php

namespace App\Http\Middleware;

use Closure;
use App\Service\LoginService;

class Seller
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
    	$user = LoginService::getLoggedInUser();

		if (!$user->isAdmin && !$user->isSeller()) {
			abort(403);
		}
		return $next($request);
    }
}