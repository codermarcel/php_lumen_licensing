<?php

namespace App\Contracts\Permissions;

use App\Helpers\AbstractEnum;

class NotePermission extends AbstractEnum
{
	const CREATE = 'note.create';
	const DELETE = 'note.delete';
	const UPDATE = 'note.update';
	const READ   = 'note.read';
}