<?php

use App\Entity\ApiKey;
use App\Entity\User;
use Faker\Generator;
use Illuminate\Support\Facades\Artisan;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCredentials()
    {
        $data = [
            'email' => 'email@email.com',
            'password' => '123456',
        ];

        $this->json('post', '/auth/credentials', $data)
             ->seeJson(['status' => 'ok',]);
    }

    public function testApiKey()
    {
        $status = $this->getJwtStatus();

        $this->assertEquals($status, 'ok');
    }

    public function testRefreshJwt($name = 'Bearer ')
    {
        $token = $this->getJwt();

        $this->post('/auth/refresh-jwt', [], ['HTTP_Authorization' => $name . $token]);

        $content = $this->parseJson($this->response);

        $this->assertEquals($content->status, 'ok');
    }

    public function testRegister()
    {
        $faker = $this->app->make(Generator::class);

        $credentials = [
            'username' => $faker->username,
            'email'    => $faker->email,
            'password' => $faker->password, //TODO : maybe assume client side hashing and set length to 64?
        ];

        $this->post('/auth/register', $credentials);

        $content = $this->parseJson($this->response);

        $this->assertEquals($content->status, 'ok');
    }


    /**
     * Test Jwt HTTP_Authorization header with Bearer prefix
     * 
     * format : Bearer <jwt>
     */
    public function testBearerToken()
    {
        $this->testRefreshJwt();
    }   

    /**
     * Test Jwt HTTP_Authorization header without Bearer prefix
     * 
     * format : <jwt>
     */
    public function testWithoutBearer()
    {
        $this->testRefreshJwt('');
    }    

    /**
     * Test using a post parameter named "jwt"
     * 
     * format : &jwt=<jwt>
     */
    public function testAsParameterToken()
    {
        $token = $this->getJwt();

        $this->post('/auth/refresh-jwt', ['jwt' => $token]);

        $content = $this->parseJson($this->response);

        $this->assertEquals($content->status, 'ok');
    }
}
