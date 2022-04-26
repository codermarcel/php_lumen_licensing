<?php

namespace App\Contracts\Permissions;

use App\Helpers\AbstractEnum;

class ExceptionPermission extends AbstractEnum
{
	const CREATE = 'exception.create';
	const DELETE = 'exception.delete';
	const UPDATE = 'exception.update';
	const READ   = 'exception.read';
}