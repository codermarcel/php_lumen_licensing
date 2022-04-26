<?php

namespace App\Contracts\Services;

interface HashInterface
{
	/**
	 * @param  string $input
	 * @return string
	 */
	public function hash($algro, $input);

	/**
	 * @param  string $hash1
	 * @param  string $hash2
	 * @return boolean true|false
	 */
	public function hash_compare(string $hash1, string $hash2);

	/**
	 * @param  [type]
	 * @return boolean true|false
	 */
	public function hash_needs_rehash(string $hash);

	/**
	 * @param  string $hash
	 * @return string
	 */
	public function hash_rehash(string $hash, $options);
}
