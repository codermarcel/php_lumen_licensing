<?php

namespace App\Providers;

use App\Contracts\Permissions\Glob\GlobalProductPermission;
use App\Contracts\Permissions\ProductPermission;
use Illuminate\Contracts\Auth\Authenticatable as User;

class PolicyProvider
{
	public function register($gate)
	{
		//Here we can check special permissions (that are dependent on other circumstances other than just the permission scope)
	    $gate->define(ProductPermission::READ, function(User $user = null, $product_id = null) {
			$user->authorize(ProductPermission::READ, $product_id);
		});
	}

	private function throwError()
	{
		throw PermissionException::notAllowed();
	}
}