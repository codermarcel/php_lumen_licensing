<?php

namespace App\Repository;

use App\Entity\Product;

class ProductRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new Product);
	}

	public function getProductsForUser($request, $user, $product_id)
	{
		$owner_id = $user->owner_id;

		$query = $this->getSearchQuery($request);
		$query->where('user_id', '=', $owner_id);
		$query->where('id', '=', $product_id);

		return $this->paginateService->returnPaginated($query);
	}
}
