<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\Token\LoginTokenContract;

class AuthController extends Controller
{

	public function login(
		Request $request,
		UserRepository $userRepository,
		LoginTokenContract $tokenGenerator
	)
	{
		$this->validate($request, [
			'email' => 'required|max:100',
			'password' => 'required|max:50'
		]);

		$user = $userRepository->findByEmail($request->email);

		if (password_verify($request->password, $user->password)) {
			return [
				'msg' => 'Successful login',
				'toke' => $tokenGenerator->generate([
					'email' => $user->email,
					'user_id' => $user->id
				])
			];
		}

		return [
			'msg' => "There's no user with your credentials"
		];	
	}

	public function register(
		Request $request,
		UserRepository $userRepository
	)
	{
		$this->validate($request, [
			'email' => 'required|max:100|unique:users,email',
			'password' => 'required|max:50',
			'name' => 'required|max:50'
		]);

		$user = $userRepository->create($request->only([
			'email', 'password', 'name'
		]));

		return [
			'msg' => "User created successfully"
		];	
	}

}

