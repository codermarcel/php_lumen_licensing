<?php

namespace App\Contracts\Permissions;

use App\Helpers\AbstractEnum;

class PostPermission extends AbstractEnum
{
	const CREATE = 'post.create';
	const DELETE = 'post.delete';
	const UPDATE = 'post.update';
	const READ   = 'post.read';
}