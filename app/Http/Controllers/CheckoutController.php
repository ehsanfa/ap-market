<?php

namespace App\Http\Controllers;

use App\Service\LoginService;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class CheckoutController extends Controller
{

	public function checkout(
		OrderRepository $orderRepository,
		ProductRepository $productRepository
	)
	{
		$user = LoginService::getLoggedInUser();
		$orders = $orderRepository->pendingOrders($user);

		if (!$orders) {
			return [
				'msg' => 'You have nothing to checkout'
			];	
		}

		// this is the place where we calculate the whole price of pending orders and return the value with a bank gateway 
		// but I'll skip this step 

		foreach ($orders as $order) {
			$orderRepository->checkout($order);
			$productRepository->checkoutByOrder($order);
		}

		return [
			'msg' => 'Checked out successfully'
		];
	}

}