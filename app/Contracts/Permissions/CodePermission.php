<?php

namespace App\Contracts\Permissions;

use App\Helpers\AbstractEnum;

class CodePermission extends AbstractEnum
{
	const CREATE = 'code.create';
	const DELETE = 'code.delete';
	const UPDATE = 'code.update';
	const READ   = 'code.read';
}