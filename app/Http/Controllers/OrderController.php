<?php

namespace App\Http\Controllers;

use App\Service\LoginService;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\StoreRepository;
use App\Repositories\ProductRepository;

class OrderController extends Controller
{
	public function index()
	{

	}

	public function store(
		$storeId,
		$productId,
		StoreRepository $storeRepository,
		ProductRepository $productRepository,
		OrderRepository $orderRepository
	)
	{
		$store = $storeRepository->findById($storeId);
		$product = $productRepository->findById($productId);
		$user = LoginService::getLoggedInUser();

		if (!$productRepository->belongsTo($product, $store)) {
			abort(404);
		}

		if ($orderRepository->hasAlreadyOrdered($product, $user)) {
			abort(404, 'You already have a pending order with this product');
		}

		if (!$productRepository->hasAnyLeft($product)) {
			abort(404, 'This product has just finished');
		}

		$orderRepository->create($product, $user);

		return [
			'msg' => 'You successfully ordered this product'
		];	
	}
}