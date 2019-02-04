<?php

namespace App\Http\Controllers;

use App\Service\LoginService;
use App\Http\Controllers\Controller;
use App\Repositories\StoreRepository;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{

	public function index(
		$storeId,
		ProductRepository $productRepository,
		StoreRepository $storeRepository
	)
	{
		$store = $storeRepository->findById($storeId);

		return $productRepository->byStore($store);
	}

	public function store(
		$storeId,
		ProductRepository $productRepository,
		StoreRepository $storeRepository,
		Request $request
	)
	{
		$this->validate($request, [
			'title' => 'required|max:50',
			'quantity' => 'required|numeric|max:100',
			'price' => 'required|numeric'
		]);

		$store = $storeRepository->findById($storeId);

		if (!$storeRepository->belongsTo($store, LoginService::getLoggedInService())) {
			abort(403);
		}

		$productRepository->create($store, $request->only([
			'title',
			'quantity',
			'price'
		]));

		return [
			'msg' => 'Product created successfully'
		];
	}

}