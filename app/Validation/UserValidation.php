<?php

namespace App\Validation;

class UserValidation
{
	public static $create = [
        'email'     => 'required|min:8|max:99|email|unique:users',
        'username'  => 'required|min:4|max:30|unique:users',
        'password'  => 'required|min:6|max:255',
	];

	/**
	 * TODO : add support to use the Username OR the Email address.
	 * 
	 * //TODO : perhaps change the minimum password min length to 64 (assuming client side hashing)
	 */
	public static $update = [
        'email'     => 'required|min:8|max:99|email|unique:users',
        //'username'  => 'min:4|max:30|unique:users',
        'password'  => 'required|min:6|max:255',
	];

	/**
	 * The loginname can be the Username OR the Email address.
	 */
	public static $delete = [
        'id'     => 'required|min:1|max:128',
	];

	/**
	 * TODO : change api token length
	 */
	public static $tokenRules = [
		'api_token'  => 'min:20|max:128',
	];
}
