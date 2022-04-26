<?php

namespace App\Repository;

use App\Entity\Permission;
use App\Entity\User;
use App\Repository\CachedBaseRepository;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\DB;

class PermissionRepository extends CachedBaseRepository
{
	public function __construct()
	{
		parent::__construct(new Permission, 'repo.permissions');
	}

	public function getByGroupId($id)
	{
        return DB::select('
        	SELECT group_permission.product_id, permissions.name
			FROM group_permission
			LEFT JOIN permissions 
			ON group_permission.permission_id=permissions.id;
		');
	}

	/**
	 * 
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function getPermissionsForUser($user_id)
	{
		$cache = $this->getCache();
		$ttl = 30;

		$value = $cache->remember('users', $ttl, function() use($user_id) {
			$user = User::where('id', $user_id)->firstOrFail();

			return $user->groups->permissions; //edit permissions / groups
		});
	}

}