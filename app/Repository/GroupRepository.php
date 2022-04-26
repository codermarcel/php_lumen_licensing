<?php

namespace App\Repository;

use App\Entity\Group;

class GroupRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new Group);
	}
}
