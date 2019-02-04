<?php

namespace App\Services\Token;

use Firebase\JWT\JWT;
use App\Services\Token\LoginTokenContract;

class JwtTokenGenerator implements LoginTokenContract
{
	const ALGORITHMS = ['HS256'];
	const DEFAULT_SECRET = 'itwillrain';

	public function generate(array $data)
	{
		return JWT::encode($data, $this->secret());
	}

	public function check(string $hash): ?array
	{
		try {
			$data = JWT::decode($hash, $this->secret(), self::ALGORITHMS);
		} catch(\Exception $e) {
			return null;
		}

		return (array) $data;
	}

	private function secret()
	{
		return env('JWT_SECRET', self::DEFAULT_SECRET);
	}

}