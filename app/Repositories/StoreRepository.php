<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Store;
use App\Repositories\AbstractRepository;

class StoreRepository extends AbstractRepository
{
	CONST LOCATION_RADIS = 0.01;

	public function index($paginate=20)
	{
		return $this->model::paginate($paginate);
	}

	public function indexNearBy($lat, $long, $paginate=20)
	{
		$lats = [$lat-self::LOCATION_RADIS, $lat+self::LOCATION_RADIS];
		$longs = [$long-self::LOCATION_RADIS, $long+self::LOCATION_RADIS];

		return $this->model::where('location_lat', $lats)
			->where('location_long', $longs)
			->paginate($paginate);
	}

	public function findById($id)
	{
		return $this->model::where('id', $id)->firstOrFail();
	}

	public function belongsTo(Store $store, User $user)
	{
		return $store->user_id == $user->id;
	}
}