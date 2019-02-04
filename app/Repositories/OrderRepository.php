<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\AbstractRepository;

class OrderRepository extends AbstractRepository
{

	public function hasAlreadyOrdered(Product $product, User $user)
	{
		return $user->orders()
			->where('product_id', $product->id)
			->where('status', 'pending')
			->exists();
	}

	public function create(Product $product, User $user)
	{
		$user->orders()->create([
			'product_id' => $product->id,
			'status' => 'pending'
		]);
	}

	public function pendingOrders(User $user)
	{
		return $user->orders()
			->where('status', 'pending')
			->get();
	}

	public function checkout(Order $order)
	{
		$order->update([
			'status' => 'checkedout'
		]);
	}

}