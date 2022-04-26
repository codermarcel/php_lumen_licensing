<?php

use App\Entity\User;
use App\Exceptions\ClientException\LoginException;

class UserTest extends TestCase
{
	public function testIndex()
	{
        $this->get('/user', $this->getJwtHeader())
            ->seeJsonStructure([
                'data' => [
                	'users' => [
                		"*" => [
                			'id', 'username'
                		]
                	]
                ]
        	]);
    }

    public function testCreate()
    {
        $data = [
            'username' => $this->getUsername(),
            'email'    => 'testemail@email.com',
            'password' => 'very_secret_123',
        ];

        $this->json('post', '/user/create', $data, $this->getJwtHeader())
            ->seeJson(['status' => 'ok',]);

        $this->seeInDatabase('users', ['username' => $data['username'], 'email' => $data['email']]);
    }

    public function testUpdate()
    {
        $data = $this->getUpdatedUserData();

        $this->json('post', '/user/update', $data, $this->getJwtHeader())
            ->seeJson(['status' => 'ok',]);

        $this->seeInDatabase('users', ['email' => $data['email']]);
    }   

    public function testPassword()
    {
        $data = $this->getUpdatedUserData();

        $this->json('post', '/auth/credentials', $data)
             ->seeJson(['status' => 'ok',]);
    }

    // public function testFailedLogin()
    // {
    //     $data = $this->getUpdatedUserData();

    //     $data['password'] = 'some_random_wrong_password'; 

    //     $this->json('post', '/auth/credentials', $data) //this sucks because it logs an exception
    //         ->seeJson(['status' => 'error',]);
    // }

    public function testDelete()
    {
        $user = $this->getUser();

        $this->json('post', '/user/delete', ['id' => $user->id], $this->getJwtHeader())
            ->seeJson(['status' => 'ok',]);
    }

    private function getUsername()
    {
        return 'test_unique_username';
    }

    private function getUser()
    {
        return User::where('username', $this->getUsername())->firstOrFail();
    }

    private function getUpdatedUserData()
    {
        $user = $this->getUser();

        return [
            'id'       => $user->id,
            'username' => $this->getUsername(),
            'email'    => 'updated_email@email.com',
            'password' => 'updated_password',
        ];
    }
}
