<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class SellerController extends Controller
{
	public function store(
		Request $request,
		UserRepository $userRepository
	)
	{
		$this->validate($request, [
			'email' => 'required|max:100|unique:users,email',
			'password' => 'required|max:50',
			'name' => 'required|max:50'
		]);

		$data = array_merge(
			$request->only(['email', 'password', 'name']),
			['role' => 'seller']
		);

		$userRepository->create($data);

		return [
			'msg' => 'Seller created successfully'
		];
	}
}