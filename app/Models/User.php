<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Store;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $fillable = [
		'email',
		'name',
		'password',
		'role',
		'location_lat',
		'location_long'
	];

	public function setPasswordAttribute(string $password)
	{
		$this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
	}

	public function isAdmin()
	{
		return $this->role == 'admin';
	}

	public function isSeller()
	{
		return $this->role == 'seller';
	}

	public function isCustomer()
	{
		return $this->role == 'customer';
	}

	public function stores()
	{
		return $this->hasMany(Store::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

}