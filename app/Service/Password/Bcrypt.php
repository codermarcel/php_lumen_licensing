<?php

namespace App\Service\Password;

use App\Contracts\Services\Password\PasswordServiceInterface;

class Bcrypt implements PasswordServiceInterface
{
	/**
	 * Disregard the salt.
	 */
	public function password_hash($password, $salt = null)
	{
		return password_hash($password, PASSWORD_BCRYPT);
	}

	/**
	 * Disregard the salt.
	 */
	public function password_verify($password, $hash, $salt = null)
	{
		return password_verify($password, $hash);
	}
}
