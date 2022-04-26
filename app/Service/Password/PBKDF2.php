<?php

namespace App\Service\Password;

use App\Contracts\Services\Password\PasswordServiceInterface;

class PBKDF2 implements PasswordServiceInterface
{
	/**
	 * [password_hash description]
	 * @param  [type] $password [description]
	 * @return [type]           [description]
	 */
	public function password_hash($password, $salt = null, $iterations = null)
	{
		$iterations = $iterations ?: $this->getIterations();

		return hash_pbkdf2($this->getAlgo(), $password, $salt, $iterations);
	}

	/**
	 * [password_verify description]
	 * @param  [type] $password [description]
	 * @param  [type] $hash     [description]
	 * @return [type]           [description]
	 */
	public function password_verify($input, $hash, $salt = null, $iterations = null)
	{
		$checkPassword = $this->password_hash($input, $salt, $iterations);

		return hash_equals($checkPassword, $hash);	//constant time.
	}

	/**
	 * Hash algorithm to use
	 */
	private function getAlgo()
	{
		return 'sha256';
	} 

	/**
	 * Amount of iterations
	 * 
	 * Defaults to 2000
	 */
	private function getIterations()
	{
		return env('PASSWORD_HASH_ITERATIONS', 2000);
	} 
}
