<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	protected $fillable = [
		'title',
		'location_lat',
		'location_long'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}