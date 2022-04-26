<?php

namespace App\Validation;

class ProductValidation
{
	public static $create = [
        'name'     => 'required|min:4|max:30|alpha_num|unique:products',
        'description'  => 'min:4|max:255',
	];

	/**
	 * The loginname can be the Username OR the Email address.
	 * 
	 * //TODO : perhaps change the minimum password min length to 64 (assuming client side hashing)
	 */
	public static $update = [
        'name'     => 'required|min:4|max:30|alnum|unique:products',
        'description'  => 'min:4|max:255',
	];
}
