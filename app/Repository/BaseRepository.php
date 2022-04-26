<?php

namespace App\Repository;

use App\Exceptions\ClientException\SearchException;
use App\Service\PaginationService;
use App\Service\Search\Search;
use Closure;
use Illuminate\Http\Request;

class BaseRepository
{
	protected $model;
	protected $paginateService;

	public function __construct($model, $paginate = null)
	{
		$this->model = $model;
		$this->paginateService = $paginate ?: app(PaginationService::class);
	}

	public function add($entity)
	{
		$entity->save();
	}

	public function all()
	{
		return $this->model->all();
	}

	public function getById($input)
	{
		return $this->model->where('id', $input)->firstOrFail();
	}

	/**
	 * Search and paginate result (magic)
	 * 
	 * @return Illuminate\Database\Query\Builder
	 */
	public function getSearchQuery(Request $request = null, $search = null, $paginate = null)
	{
		$request = $request ?: app(Request::class);
		$search  = $search ?: app(Search::class);

		$query   = $search->makeQuery($this->model, $request);
		$query   = $this->paginateService->paginateViaRequest($request, $query);

		return $query;
	}
}
