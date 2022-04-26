<?php

use App\Entity\ApiKey;
use App\Entity\Group;
use App\Entity\Permission;
use App\Entity\Product;
use App\Entity\Role;
use App\Entity\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//Owner / Admin
    	$owner = User::where('username', 'admin')->first();

    	//Create and assign Products
    	$product = new Product;
    	$product->name = 'Net Seal 3';
    	$owner->products()->save($product);

    	$product2 = new Product;
    	$product2->name = 'NanoCore 2';
    	$owner->products()->save($product2);

    	//Create and assign Apikey
    	$key = new ApiKey;
    	$owner->api_keys()->save($key);

    	//Create and assign Group
    	$group = new Group;
    	$group->name = 'Moderators';
    	$owner->groups()->save($group);
    	$this->assignGroupPermissions($group);

    	//Assign role to user.
    	$role = new Role;
    	$role->group_id = $group->id;
    	$owner->role()->save($role);
    }

    private function assignGroupPermissions($group)
    {
        $permissions = Permission::where('name', 'like', 'code.%')->get();
        $global_perm = Permission::where('isGlobal', '=', 1)->get();

        $group->permissions()->attach($permissions, ['product_id' => '1']);
        $group->permissions()->attach($global_perm);
    }


}
