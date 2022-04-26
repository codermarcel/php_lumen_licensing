<?php

namespace App\Service\Api;

use FluidXml\FluidXml;
use Illuminate\Http\Response;

class XmlResponse
{
	const CONTENT_TYPE = 'application/xml';

	/**
	 * Transform to xml response
	 */
    public static function transform(array $content, array $headers = [])
    {
        $xml = (new FluidXml())->add($content);

        $response = new Response($xml, 200, $headers);
        $response->header('Content-Type', self::CONTENT_TYPE);

        return $response;
    }
}