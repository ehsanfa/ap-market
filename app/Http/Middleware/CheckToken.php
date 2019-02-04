<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Service\LoginService;
use App\Repositories\UserRepository;
use App\Services\Token\LoginTokenContract;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard=null)
    {
    	$tokenChecker = app(LoginTokenContract::class);

    	if (!$request->hasHeader('Token') || !$decodedToken = $tokenChecker->check($request->header('Token'))) {
    		abort(403);
    	}

    	$userRepository = app(UserRepository::class);

    	LoginService::loginUsingId($userRepository->findByEmail($decodedToken['email']));

        return $next($request);
    }
}
