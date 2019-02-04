<?php

namespace App\Repositories;

class UserRepository extends AbstractRepository
{
	public function adminExists()
	{
		return $this->model::where('role', 'admin')->exists();
	}

	public function findByEmail(string $email)
	{
		return $this->model::where('email', $email)->firstOrFail();
	}

	public function create(array $credentials)
	{
		$this->model::create($credentials);
	}

}