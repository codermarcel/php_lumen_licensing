<?php

namespace App\Contracts\Services;

interface ValidationInterface
{
	/**
	 * Validate input
	 * @param  mixed $input
	 * @return boolean true|false
	 */
	public function validUsername($input);

	/**
	 * Validate input
	 * @param  mixed $input
	 * @return boolean true|false
	 */
	public function validPassword($input);

	/**
	 * Validate input
	 * @param  mixed $input
	 * @return boolean true|false
	 */
	public function validEmail($input);

	/**
	 * Validate input
	 * @param  mixed $input
	 * @return boolean true|false
	 */
	public function validToken($input);
}
