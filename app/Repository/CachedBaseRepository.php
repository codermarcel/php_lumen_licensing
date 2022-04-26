<?php

namespace App\Repository;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Model;

class CachedBaseRepository extends BaseRepository
{
	private $cache;
	private $tag;
	private $cache_ttl = 60; // 1 hour

	public function __construct(Model $model = null, $tag = 'repo.default', Cache $cache = null)
	{
		parent::__construct($model);

		$this->tag = $tag;
		$this->cache = $cache ?: app(Cache::class);
	}

	/**
	 * Just use md5 for performance reasons.
	 * 
	 * The input should be __METHOD__ (which returns something like -> App\Repository\PermissionRepository::getPermissionsForUser)
	 * AND an id (user_id, owner_id, whatever)
	 * 
	 * We won't have any collisions (hopefully) because we set a cache tag which drastically
	 * reduces the chance of collisions for the same cache tag.
	 */
	public function getKey($input)
	{
		return hash('md5', $input);
	}

	public function getCacheTtl()
	{
		return $this->cache_ttl;
	}

	protected function getCache()
	{
		return $this->cache->tags($this->tag);
	}
}
