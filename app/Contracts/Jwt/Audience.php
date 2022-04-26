<?php

namespace App\Contracts\Jwt;

interface Audience
{
	const KEY         = 'api_key';
	const USER        = 'user';
	const RECOVER     = 'recover';
}