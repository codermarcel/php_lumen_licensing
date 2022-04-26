<?php

namespace App\Exceptions\ServerException;

use App\Exceptions\ServerException;

class CryptoException extends ServerException
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message, $code = 500)
	{
		parent::__construct($message, $code);
	}

	public static function badCrypto()
	{
		return new static('Uncaught crypto exception');
	}

	public static function opensslFail()
	{
		return new static('openssl_random_pseudo_bytes() failed.');
	}

	public static function opensslFunction()
	{
		return new static('The openssl_random_pseudo_bytes() function does not exist.');
	}

	public static function badLength($length, $required)
	{
		return new static("The minimum length is $required, you chose $length"); //chose, not choose (right?)
	}
}
