<?php

use App\Exceptions\ClientException\SearchException;

class SearchTest extends TestCase
{
    private function makeRequest(array $data = [])
    {
        return $this->json('get', '/user', $data, $this->getJwtHeader());
    }

    public function testOk()
    {
        $request = $this->makeRequest();
        $request->seeJson(['status' => 'ok']);
    }

    /**
     * Filter
     */
    private function filter(array $filter)
    {
        $request = $this->makeRequest(['filter' => $filter]);

        $request->seeJsonStructure([
            'data' => [
                'users' => [
                    "*" => $filter
                ]
            ]
        ]);
    }

    public function testFilterA()
    {
        $this->filter(['username']);
    }    

    public function testFilterB()
    {
        $this->filter(['username', 'id']);
    }
    
    public function testFilterC()
    {
        $this->filter(['username', 'id', 'email_confirmed']);
    }    

    /**
     * We expect an exception here because we search for the password field.
     */
    public function testFilterD()
    {
        $this->setExpectedException(SearchException::class);

        $this->filter(['username', 'id', 'password']);
    }

    /**
     * Where
     */
    private function search(array $where, array $orWhere = [], array $filter = [])
    {
        $request = $this->makeRequest([
            'where'   => $where,
            'orWhere' => $orWhere,
            //'filter'  => $filter,
        ]);
$this->debug();
        $request->seeJsonStructure([
            'data' => [
                'users' => [
                    "*" => $filter
                ]
            ]
        ]);



        return $this->response;
    }

    public function testFilterAndWhereA()
    {
        $where   = ['credits=1337'];
        $orWhere = [];
        $filter  = ['username', 'id'];

        $request = $this->search($where, $orWhere, $filter);
        $count   = $this->parseJson($request)->data->count;

        $this->assertTrue($count === 10);
    }

}
