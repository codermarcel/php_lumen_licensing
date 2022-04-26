<?php

namespace App\Repository;

use App\Entity\Code;
use App\Entity\RegisterCode;
use Illuminate\Support\Facades\Cache;

class CodeRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new Code);
	}
}
