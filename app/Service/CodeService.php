<?php

namespace App\Service;

use App\Repository\CodeRepository;
use App\Service\RandomService;

class CodeService 
{
	private $codes;
	private $random;

	public function __construct(CodeRepository $codes, RandomService $random)
	{
		$this->codes = $codes;
		$this->random = $random;
	}



	public function createCode(Request $request)
	{
		$code = new Code();
		$code->code = $this->random->generateCode();
		$code->duration = $request->input('duration');
		$code->user_id = PermissionSerivce::getOwnerId();
		$code->save();

		return $code;
	}


}

