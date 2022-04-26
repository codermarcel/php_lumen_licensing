<?php

namespace App\Service\Api;

class JsonResponse
{
	const CONTENT_TYPE = 'application/json';

	/**
	 * Transform to json response
	 */
    public static function transform(array $content, array $headers = [])
    {
    	return response()->json($content, 200, $headers);
    }
}