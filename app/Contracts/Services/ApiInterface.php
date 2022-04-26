<?php

namespace App\Contracts\Services;

interface ApiInterface
{
	/**
	 * Translate success into outputable message or view.
	 * 
	 * @param  mixed $description
	 * @return mixed outputable message or view.
	 */
    public function makeSuccess($code = 200, $description = null, array $data = null);

	/**
	 * Translate exception into outputable message or view.
	 * 
	 * @param  exception $exception
	 * @return mixed outputable message or view.
	 */
    public function makeFail(\Exception $exception);
}