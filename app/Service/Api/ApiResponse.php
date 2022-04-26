<?php

namespace App\Service\Api;

use App\BusinessLogic\HttpStatusCodes;
use App\Service\Api\ExceptionConverter;
use App\Service\Api\JsonResponse;
use App\Service\Api\XmlResponse;
use App\Service\Request\Limiter;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ApiResponse
{
	/**
	 * Private vars
	 */
	private $content = array();
	private $headers = array();
	private $status;
	protected $request;

	public function __construct(Request $request = null)
	{
		$this->setCode(200);
		$this->request = $request;
	}

	/**
	 * Fluent
	 */
	public function setCode($code)
	{
		$code = HttpStatusCodes::isValidValue($code) ? $code : 500;

		return $this->set('code', $code);
	}	

	private function setDefaults()
	{
		$code        = $this->get('code');
		$success     = HttpStatusCodes::isSuccess($code);
		$description = HttpStatusCodes::getDescription($code);

		$this->status = $success ? 'ok' : 'error';

		if ( ! $success) //its redundant to set the status to 'ok' and the description to 'ok' as well.
		{
			$this->set('description', $description);
		}
	}

	public function toArray()
	{
		$this->setDefaults();

		return [
			'status' => $this->status,
			'data'   => $this->content,
		];
	}

	public function toXml()
	{
		return (new XmlResponse())->transform($this->toArray(), $this->headers);
	}

	public function toJson()
	{
		return (new JsonResponse())->transform($this->toArray(), $this->headers);
	}


	public function build(Request $request = null)
	{
		$request = $request ?: $this->request;

		$asJson = empty($request) ? true : $request->accepts([JsonResponse::CONTENT_TYPE, 'json']);

		if ($asJson)
		{
			return $this->toJson();
		}

		return $this->toXml();
	}

	/**
	 * Content
	 */
	public function set($key, $value, $asHeader = false)
	{
		if ( ! $asHeader)
		{
			$this->content[$key] = $value;

			return $this;
		}

		return $this->setHeader($key, $value);
	}

	private function get($key)
	{
		return $this->content[$key];
	}

	/**
	 * Header
	 */
	public function setHeader($key, $value)
	{
		$this->headers[$key] = $value;

		return $this;
	}

	public function getHeader($key, $value)
	{
		return $this->headers[$key];
	}
}