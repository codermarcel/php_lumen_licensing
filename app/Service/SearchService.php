<?php

namespace App\Service;

use App\Exceptions\ClientException\SearchException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchService 
{
	/**
	 * Vars
	 */
	private $model;

	/**
	 * [makeQuery description]
	 * @param  Model   $model   [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function makeQuery(Model $model, Request $request)
	{
		$this->model = $model;
		$query = $model;

		$filters = $request->input('filter');
		$wheres = $request->input('where');
		$orWheres = $request->input('orWhere');

		$query = $this->applyWheres($query, $wheres);

		return $query;
		$query = $this->applyOrWheres($query, $orWheres);
		$query = $this->applyFilters($query, $filters);

		return $query;
	}

	private function applyFilters($query, $filters)
	{
		$all = [];

		if (empty($filters))
		{
			return $query;
		}

		foreach ($filters as $index => $filter)
		{
			$this->checkBlackList($filter);
			$all[] = $filter;
		}

		return $query->select($all);
	}

	private function applyWheres($query, $wheres)
	{
		return $this->apply($query, $wheres, 'where');
	}

	private function applyOrWheres($query, $wheres)
	{
		return $this->apply($query, $wheres, 'orWhere');
	}

	public function apply($query, $wheres, $name)
	{
		if (empty($wheres) || ! is_array($wheres))
		{
			return $query;
		}

		foreach ($wheres as $index => $where)
		{
			list($field, $operator, $value) = $this->splitWhere($where);
			
			$query->$name($field, $operator, $value);
		}

		return $query;
	}

	/**
	 * Check if the models hidden field has any fields that are in the models hidden array.
	 * 
	 * $name is the "field" (username, password, email, created_at, etc)
	 */
	private function checkBlackList($name)
	{
		$hidden = $this->model->getHidden();

		foreach ($hidden as $hid)
		{
			if ($hid === $name)
			{
				throw SearchException::blacklisted($name);
			}
		}
	}

	/**
	 * Check if the models hidden fieldhas any fields that are in the models hidden array.
	 */
	private function checkValueBlacklist($value)
	{
		$start = '%';

		if (starts_with($value, $start))
		{
			$value = $this->convertValue($value, true); //convert % back to *
			$start = $this->convertValue($start, true); //convert % back to *

			throw SearchException::blacklistedValueStart($value, $start);
		}
	}

	/**
	 * $filter   = field name (username, password, etc)
	 * 
	 * $operator = splitter send to the api ('=', '>', '<', '*')
	 * 
	 * $function = function that the operator gets converted to ('=', '>', '<', 'like')
	 * 
	 * $value    = value to "operate" on (example : username=admin) 'admin' would be the value
	 */
	private function splitWhere($where)
	{
		list($operator, $function) = $this->getSplitter($where);
		list($field_name, $value) = explode($operator, $where);

		$value = $this->convertValue($value);

		$this->checkBlackList($field_name);
		$this->checkValueBlacklist($value);

		return [$field_name, $function, $value];
	}

	private function convertValue($value, $reverse = false) 
	{
		$ast = '*';
		$per = '%';

		if ($reverse && str_contains($value, $per))
		{
			return str_replace($per, $ast, $value);
		}

		if (str_contains($value, $ast))
		{
			return str_replace($ast, $per, $value);
		}

		return $value;
	}

	private function getSplitter($string)
	{
		$splitters = [
			'='    => '=',
			'>'    => '>',
			'<'    => '<',
			'~'    => 'like',
		];

		foreach ($splitters as $operator => $function)
		{
			if (str_contains($string, $operator))
			{
				return [$operator, $function];
			}
		}

		throw SearchException::badOperator();
	}
}
