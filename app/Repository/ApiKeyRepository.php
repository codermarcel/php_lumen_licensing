<?php

namespace App\Repository;

use App\Entity\ApiKey;
use App\Entity\RegisterCode;
use Illuminate\Support\Facades\Cache;

class ApiKeyRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new ApiKey);
	}

	public function getByToken($token)
	{
		return $this->model->where('token', $token)->firstOrFail();
	}

}