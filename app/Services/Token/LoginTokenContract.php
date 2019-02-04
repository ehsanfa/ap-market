<?php

namespace App\Services\Token;

interface LoginTokenContract 
{
	public function generate(array $data);

	public function check(string $hash): ?array;
}