<?php

namespace App\Contracts\Services\Password;

interface PasswordServiceInterface
{
	public function password_hash($password, $salt = null);
	public function password_verify($password, $hash, $salt = null);
}