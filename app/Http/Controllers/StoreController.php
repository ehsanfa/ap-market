<?php

namespace App\Http\Controllers;

use App\Service\LoginService;
use App\Http\Controllers\Controller;
use App\Repositories\StoreRepository;

class StoreController extends Controller
{

	public function index(
		StoreRepository $storeRepository
	)
	{
		$user = LoginService::getLoggedInUser();

		return $storeRepository->indexNearBy(
			$user->location_lat,
			$user->location_long
		);
	}

	public function store(
		Request $request,
		StoreRepository $storeRepository
	)
	{
		$this->validate([
			'title' => 'required|max:50',
		]);

		$user->stores()->create($request->only([
			'name',
			'location_lat',
			'location_long'
		]));

		return [
			'msg' => 'Store created successfully'
		];
	}

}