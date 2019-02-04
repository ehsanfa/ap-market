<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Repositories\AbstractRepository;

class ProductRepository extends AbstractRepository
{
	public function findById($productId)
	{
		return $this->model::where('id', $productId)->firstOrFail();
	}

	public function byStore(Store $store, $paginate=20)
	{
		return $store->products()->paginate($paginate);
	}

	public function create(Store $store, array $data)
	{
		$store->products()->create($data);
	}

	public function belongsTo(Product $product, Store $store)
	{
		return $store->products()->where('id', $product->id)->exists();
	}

	public function hasAnyLeft(Product $product)
	{
		return $product->quantity > 0;
	}

	public function checkoutByOrder(Order $order)
	{
		$order->product()->update([
			'quantity' => $order->product->quantity
		]);
	}
}