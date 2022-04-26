<?php

use App\Entity\User;

class CodeTest extends TestCase
{
	public function testExampke()
	{
		$this->assertTrue(true);
	}
	// public function testIndex()
	// {
 //        $this->get('/user', $this->getJwtHeader())
 //            ->seeJsonStructure([
 //                'data' => [
 //                	'users' => [
 //                		"*" => [
 //                			'id', 'username', 'email'
 //                		]
 //                	]
 //                ]
 //        	]);
 //    }

 //    public function testShow()
 //    {
 //        $this->json('get', '/user/show', ['id' => 1], $this->getJwtHeader())
 //            ->seeJsonStructure([
 //                'data' => [
 //                    'user' => [
 //                        'id', 'username', 'email'
 //                    ]
 //                ]
 //            ]);
 //    }

 //    private function getUsername()
 //    {
 //        return 'test_unique_username';
 //    }

 //    private function getUser()
 //    {
 //        return User::where('username', $this->getUsername())->firstOrFail();
 //    }

 //    public function testCreate()
 //    {
 //        $data = [
 //            'username' => $this->getUsername(),
 //            'email'    => 'testemail@email.com',
 //            'password' => 'very_secret_123',
 //        ];

 //        $this->json('post', '/user/create', $data, $this->getJwtHeader())
 //            ->seeJson(['status' => 'ok',]);
 //    }

 //    public function testUpdate()
 //    {
 //        $user = $this->getUser();

 //        $data = [
 //            'username' => $this->getUsername(),
 //            'email'    => 'updated_email@emai..com',
 //            'password' => 'updated_password',
 //        ];

 //        $this->json('post', '/user/update', ['id' => $user->id, $data], $this->getJwtHeader())
 //            ->seeJson(['status' => 'ok',]);
 //    }

 //    public function testDelete()
 //    {
 //        $user = $this->getUser();

 //        $this->json('post', '/user/delete', ['id' => $user->id], $this->getJwtHeader())
 //            ->seeJson(['status' => 'ok',]);
 //    }
}
