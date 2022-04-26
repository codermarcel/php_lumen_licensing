<?php

namespace App\Repository;

use App\Entity\Ban;
use Illuminate\Support\Facades\Cache;

class BanRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new Ban);
	}
}
