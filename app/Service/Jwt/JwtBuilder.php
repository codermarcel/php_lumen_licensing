<?php

namespace App\Service\Jwt;

use App\Exceptions\ClientException\JwtException;
use App\Service\Time\Time;
use Illuminate\Http\Request;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

class JwtBuilder extends Jwt
{
	private $subject = false;
	private $builder;
	private $time;

	public function __construct()
	{
		$this->builder = new Builder();
		$this->setTimes();
	}

	/**
	 * Required Public setters
	 */
	public function setSubject($subject)
	{
		$this->subject = true;

		return $this->set('sub', $subject);
	}

	public function setAudience($audience)
	{
		return $this->set('aud', $audience);
	}

	/**
	 * Generate the token
	 * @return string
	 */
	public function getToken()
	{
		$this->checkRequiredFields();

		$this->setTimes();

		$this->setIdentifiers();

		return (string) $this->builder->getToken();
	} 

	/**
	 * Set identifiers to invalidate jwts.
	 */
	private function setIdentifiers()
	{
		$this->set('jpk', $this->getPublic());

		$this->builder->sign($this->getSigner(), $this->getSecret());

		return $this;
	}

	/**
	 * Check if owner and subject are set.
	 */
	private function checkRequiredFields()
	{
		$ok = $this->subject ? true : false;

		if ( ! $ok)
		{
			throw JwtException::requiredFields();
		}
	}

	/**
	 * Fluent
	 */
	public function setIssuedAt($time)
	{
		$this->builder->setIssuedAt($time);

		return $this;
	}

	/**
	 * Fluent
	 */
	public function setIssuedAtIn($input)
	{
		$time = 60 * $input; //in minutes

		return $this->setIssuedAt($this->time + $time);
	}

	/**
	 * Fluent
	 */
	public function setNotBefore($time)
	{
		$this->builder->setNotBefore($time);

		return $this;
	}

	/**
	 * Fluent
	 */
	public function setNotBeforeIn($input)
	{
		$time = 60 * $input; //in minutes

		return $this->setNotBefore($this->time + $time);
	}

	/**
	 * Fluent
	 */
	public function setExpiration($time)
	{
		$this->builder->setExpiration($time);

		return $this;
	}

	/**
	 * Fluent
	 */
	public function setExpirationIn($input)
	{
		$time = 60 * $input; //in minutes

		return $this->setExpiration($this->time + $time);
	}

	/**
	 * Set iat, nbf and exp
	 */
	private function setTimes($time = null)
	{
		$time = Time::now();
		$this->time = $time;

		$this->setIssuedAt($time);
		$this->setNotBefore($time);
		$this->setExpiration($time + $this->getExpireDuration());

		return $this;
	}

	/**
	 * Set a key value pair
	 */
	private function set($key, $value)
	{
		$this->builder->set($key, $value);

		return $this;
	}
}
