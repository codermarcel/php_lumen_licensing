<?php

namespace App\Validation;

class AuthValidation
{
	/**
	 * The loginname can be the Username OR the Email address.
	 * 
	 * //TODO : perhaps change the minimum password min length to 64 (assuming client side hashing)
	 */
	public static $credentialRules = [
        'email'     => 'required|min:8|max:99|email',
        'password'  => 'required|min:6|max:255',
	];

	/**
	 * TODO : change api token length
	 */
	public static $tokenRules = [
		'apikey'  => 'required|min:20|max:40',
	];
}
