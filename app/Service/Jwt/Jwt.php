<?php

namespace App\Service\Jwt;

/**
 * Base JWT class with sensible default settings.
 * 
 * You may change most values in the .env file.
 */
class Jwt
{
	/**
	 * Get the signer used for signing the JWT
	 * 
	 * Don't change this!
	 */
	protected function getSigner()
	{
		return new \Lcobucci\JWT\Signer\Hmac\Sha256;
	}

	/**
	 * Gets the secret that we use to sign and verify the JWT
	 * 
	 * When changing this, it will invalidate every jwt tokens and users need to create a new jwt.
	 * 
	 * You can change this value in the .env file
	 */
	protected function getSecret()
	{
		return env('JWT_SECRET'); //NOTE : changeable
	}

	/**
	 * Gets the public key that we use to create and verify the JWT
	 * 
	 * When changing this, it will invalidate every jwt tokens and users need to create a new jwt.
	 * 
	 * You can change this value in the .env file
	 */
	protected function getPublic()
	{
		return env('JWT_PUBLIC'); //NOTE : changeable
	}

	/**
	 * Gets the duration that the jwt should be valid (iat + X = exp) in SECONDS
	 *
	 * When changing this, it will not invalidate already generated jwts.
	 * 
	 * Defaults to 20 minutes.
	 */
	protected function getExpireDuration()
	{
		$seconds = 60 * 20; //20 minutes

		return env('JWT_DURATION', $seconds); //NOTE : changeable
	}
}
