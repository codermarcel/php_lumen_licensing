<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( ! app()->environment(['prod','production']))
        {
            $this->call(PermissionTableSeeder::class); //staging environment

            if ( ! app()->environment(['staging']))
            {
                $this->call(UserTableSeeder::class);
                $this->call(TestDataSeeder::class);
            }
        }
    }
}
