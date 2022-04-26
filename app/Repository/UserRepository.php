<?php

namespace App\Repository;

use App\Entity\User;
use Illuminate\Support\Facades\Cache;

class UserRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new User);
	}

	public function getUsersForOwner($request, $owner_id)
	{
		$query = $this->getSearchQuery($request);

		$query->where('owner_id', '=', $owner_id);

		return $this->paginateService->returnPaginated($query);
	}

	public function findByEmail($input)
	{
		return $this->model->where('email', $input)->first();
	}

	public function getByUsername($input)
	{
		return $this->model->where('username', $input)->firstOrFail();
	}

	public function getByEmail($input)
	{
		return $this->model->where('email', $input)->firstOrFail();
	}

	public function findByUsernameOrEmail($username = null, $email = null)
	{
		return $this->model
			->where('username', $username)
			->orWhere('email', $email)
			->first();
	}

	public function getByUsernameOrEmail($username = null, $email = null)
	{
		return $this->model
			->where('username', $username)
			->orWhere('email', $email)
			->firstOrFail();
	}
}
