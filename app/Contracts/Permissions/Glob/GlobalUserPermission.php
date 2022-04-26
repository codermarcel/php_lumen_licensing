<?php

namespace App\Contracts\Permissions\Glob;

use App\Helpers\AbstractEnum;

class GlobalUserPermission extends AbstractEnum
{
	const CREATE = 'user.create';
	const DELETE = 'user.delete';
	const UPDATE = 'user.update';
	const READ   = 'user.read';
}