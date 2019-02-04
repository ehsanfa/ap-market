<?php

namespace App\Service;

use App\Models\User;

class LoginService
{

	private static $loggedInUser = null;

	public static function check()
	{
		return self::$loggedInUser;
	}

	public static function loginUsingId(User $user)
	{
		self::$loggedInUser = $user;
	}

	public static function getLoggedInUser()
	{
		return self::$loggedInUser;
	}

}