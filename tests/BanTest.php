<?php

use App\Entity\Ban;
use App\Entity\Product;
use App\Entity\User;

class BanTest extends TestCase
{

    public function testExample()
    {
        $this->assertTrue(true);
    }

    // public function testCreate()
    // {
    //     $data = [
    //         'reason'   => $this->getReason(),
    //         'user_id' => 1,
    //         'product_id' => 1,
    //     ];

    //     $this->json('post', '/ban/create', $data, $this->getJwtHeader())
    //         ->seeJson(['status' => 'ok',]);

    //     $this->seeInDatabase('bans', $data);
    // }

    // public function testIndex()
    // {
    //     $this->get('/ban', $this->getJwtHeader())
    //         ->seeJsonStructure([
    //             'data' => [
    //                 'bans' => [
    //                     "*" => [
    //                         'product_id', 'user_id', 'reason'
    //                     ]
    //                 ]
    //             ]
    //         ]);
    // }

    // public function testUpdate()
    // {
    //     $ban = $this->getBan();

    //     $data = [
    //         'id'      => $ban->id,
    //         'user_id' => $ban->user_id,
    //         'reason'  => $ban->reason,
    //     ];

    //     $this->json('post', '/ban/update', $data, $this->getJwtHeader())
    //         ->seeJson(['status' => 'ok',]);

    //     $this->seeInDatabase('bans', $data);
    // }

    // // public function testDelete()
    // // {
    // //     $ban = $this->getBan();

    // //     $this->json('post', '/ban/delete', ['id' => $ban->id], $this->getJwtHeader())
    // //         ->seeJson(['status' => 'ok',]);
    // // }

    // private function getReason()
    // {
    //     return 'You have been banned because fuck you';
    // }

    // private function getBan()
    // {
    //     return Ban::where('id', 1)->firstOrFail();
    // }
}
