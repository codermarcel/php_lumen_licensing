<?php

namespace App\Service;

use App\Entity\BaseEntity; //Type hint the base entity to ensure validation.
use App\Exceptions\ClientException\DatabaseException;
use Illuminate\Http\Request;
use Exception;

class EntityService 
{
	/**
	 * Create Entity
	 */
	public function createEntity(BaseEntity $entity)
	{
		if ( ! $entity->save())
		{
			throw DatabaseException::create();
		}

		return $entity;
	}

	/**
	 * Update Entity
	 */
	public function updateEntity(BaseEntity $entity, array $data)
	{
		$entity = $entity->fill($data);

		if ( ! $entity->save())
		{
			throw DatabaseException::update();
		}

		return $entity;
	}

	/**
	 * Delete Entity
	 */
	public function deleteEntity(BaseEntity $entity)
	{
		if ( ! $entity->delete())
		{
			throw DatabaseException::delete();
		}

		return $entity;
	}
}

