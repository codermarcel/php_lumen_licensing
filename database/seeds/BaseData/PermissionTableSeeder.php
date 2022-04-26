<?php

use App\BusinessLogic\Packages\Package;
use App\BusinessLogic\Roles\Role;
use App\Contracts\Permissions\CodePermission;
use App\Contracts\Permissions\ExceptionPermission;
use App\Contracts\Permissions\Glob\GlobalProductPermission;
use App\Contracts\Permissions\Glob\GlobalUserPermission;
use App\Contracts\Permissions\NotePermission;
use App\Contracts\Permissions\PostPermission;
use App\Contracts\Permissions\ProductPermission;
use App\Contracts\Permissions\SettingsPermission;
use App\Entities\Eloquent\EloquentUser;
use App\Entity\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Product based permissions
        $this->create(ExceptionPermission::toArray());
        $this->create(NotePermission::toArray());
        $this->create(PostPermission::toArray());
        $this->create(ProductPermission::toArray());
        $this->create(SettingsPermission::toArray());
        $this->create(CodePermission::toArray());

        //Global permissions.
        $this->createGlobal(GlobalProductPermission::toArray());
        $this->createGlobal(GlobalUserPermission::toArray());
    }

    private function create($perm)
    {
        DB::transaction(function () use($perm){

            foreach ($perm as $key => $value)
            {
                Permission::firstOrCreate(['name' => $value, 'isGlobal' => false]);
            }

        });
    }

    private function createGlobal($perm)
    {
        DB::transaction(function () use($perm){

            foreach ($perm as $key => $value)
            {
                Permission::firstOrCreate(['name' => $value, 'isGlobal' => true]);
            }

        });
    }
}
