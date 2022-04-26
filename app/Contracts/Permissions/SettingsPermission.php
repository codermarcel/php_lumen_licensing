<?php

namespace App\Contracts\Permissions;

use App\Helpers\AbstractEnum;

class SettingsPermission extends AbstractEnum
{
	const CREATE = 'note.create';
	const DELETE = 'exception.delete';
	const UPDATE = 'exception.update';
	const READ   = 'exception.read';
}