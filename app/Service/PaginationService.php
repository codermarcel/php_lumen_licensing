<?php

namespace App\Service;

use Illuminate\Http\Request;

class PaginationService 
{
	/**
	 * Paginate via request.
	 * 
	 * @return Illuminate\Database\Query\Builder
	 */
	public function paginateViaRequest(Request $request, $query = null)
	{
		return $this->getPaginateQuery($request->input('limit'), $request->input('offset'), $query);
	}

	/**
	 * Paginate.
	 * 
	 * @return Illuminate\Database\Query\Builder
	 */
	public function getPaginateQuery($amount = null, $offset = null, $query = null)
	{
		$amount = $this->getPaginateAmount($amount);
		$offset = $offset ?: 0;
		$query = $query ?: $this->model;

		return $query->take($amount)->skip($offset);
	}

	/**
	 * Return total amount of results and query results.
	 * 
	 * @return array
	 */
	public function returnPaginated($query = null)
	{
		$query = $query ?: $this->model;
		
		return [$query->getCountForPagination(), $query->get()];
	}

	/**
	 * Get pagination amount
	 * 
	 * @return int
	 */
	private function getPaginateAmount($input)
	{
		return empty($input) ? $this->maxPaginate() : $this->getSmallest($input);
	}

	/**
	 * Return the smallest value between $input and maxPaginate();
	 * 
	 * @return int
	 */
	private function getSmallest($input)
	{
		return $input < $this->maxPaginate() ? $input : $this->maxPaginate();
	}

	/**
	 * Maximum number of results to take from the database.
	 * NOTE : CHANGEABLE
	 * 
	 * @return int
	 */
	private function maxPaginate()
	{
		return env('PAGINATE_MAX_AMOUNT', 30);
	}
}

