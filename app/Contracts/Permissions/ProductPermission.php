<?php

namespace App\Contracts\Permissions;

use App\Helpers\AbstractEnum;

class ProductPermission extends AbstractEnum
{
	const DELETE = 'product.delete';
	const UPDATE = 'product.update';
	const READ   = 'product.read';
}