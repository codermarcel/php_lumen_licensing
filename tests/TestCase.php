<?php

use App\Entity\ApiKey;
use App\Service\Permission\TestPermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $dbname = env('DB_DATABASE_TEST', 'state_test'); //NOTE : changeable : change to test database

        putenv('DB_DATABASE=' . $dbname); 

        $app = require __DIR__.'/../bootstrap/app.php';

        return $app;
    }

    protected static $initiated = false;

    protected static function db()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }

    public function setUp()
    {        
        parent::setUp();

        $this->createApplication();

        if ( ! static::$initiated)
        {
            static::$initiated = true;
            static::db();
        }
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * 
     */
    protected function debug()
    {
        dd($this->parseJson($this->response));
    }

    /**
     * 
     */
    protected function parseJson($response)
    {
        return json_decode($response->getContent());
    }

    /**
     * 
     */
    public function getJwtHeader()
    {
        $token = $this->getJwt();

        return ['HTTP_Authorization' => 'Bearer ' . $token];
    }

    /**
     * 
     */
    public function getJwt()
    {
        list($token, $status) = $this->getJwtResponse();

        return $token;
    }

    /**
     * 
     */
    public function getJwtStatus()
    {
        list($token, $status) = $this->getJwtResponse();

        return $status;
    }    

    /**
     * 
     */
    public function getJwtResponse()
    {
        $apikey = ApiKey::where('id', 1)->firstOrFail();

        $response = $this->call('post', '/auth/apikey', ['apikey' => $apikey->token]);

        $content = $this->parseJson($response);

        return [$content->data->token, $content->status];
    }
}
