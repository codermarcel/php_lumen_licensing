<?php

use App\Contracts\Services\Password\PasswordServiceInterface;
use App\Entity\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    const UNIT_TEST_AMOUNT = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( ! User::where('username', 'admin')->first())
        {
            $this->seedOwners();
            $this->seedRegular();
            $this->seedUnitTestData();
        }
    }

    /**
     * Seed owners.
     */
    private function seedOwners()
    {
        /**
         * Seed admin.
         */
        factory(App\Entity\User::class, 'admin', 1)->create();

        /**
         * Seed some regular owners.
         */
        factory(App\Entity\User::class, 5)->create();
    }

    /**
     * Seed regular users that are being owned by parent users.
     */
    private function seedRegular()
    {
        /**
         * Seed users owned by owner with id 1
         */
        factory(App\Entity\User::class, 20)->make()->each(function($u){
            $u->owner_id = 1;
            $u->save();
        });

        /**
         * Seed users owned by owner with id 2
         */
        factory(App\Entity\User::class, 20)->make()->each(function($u){
            $u->owner_id = 2;
            $u->save();
        });

        /**
         * Seed users owned by the admin account
         */
        $owner_id = $this->getAdminId();

        factory(App\Entity\User::class, 20)->make()->each(function($u) use($owner_id){
            $u->owner_id = $owner_id;
            $u->save();
        });
    }

    /**
     * Seed unit test data.
     */
    private function seedUnitTestData()
    {
        /**
         * Seed some unit test data.
         */
        factory(App\Entity\User::class, 'test', self::UNIT_TEST_AMOUNT)->create();
    } 

    /**
     * Get admin id
     */
    private function getAdminId()
    {
        return User::where('username', 'admin')->firstOrFail()->id;
    }
}
