<?php

namespace App\Contracts\Permissions\Glob;

use App\Helpers\AbstractEnum;

class GlobalGroupPermission extends AbstractEnum
{
	const CREATE = 'group.create';
	const DELETE = 'group.delete';
	const UPDATE = 'group.update';
	const READ   = 'group.read';
}