<?php

use App\Entity\Product;
use App\Entity\User;

class ProductTest extends TestCase
{
    public function testTesting()
    {
        $this->assertTrue(true);
    }
    
    // public function testIndex()
    // {
    //     $this->get('/product', $this->getJwtHeader())
    //         ->seeJsonStructure([
    //             'data' => [
    //                 'products' => [
    //                     "*" => [
    //                         'name', 'description'
    //                     ]
    //                 ]
    //             ]
    //         ]);
    // }

    // private function getProductName()
    // {
    //     return 'test_unique_product';
    // }

    // private function getProduct()
    // {
    //     return Product::where('name', $this->getProductName())->firstOrFail();
    // }

    // public function testCreate()
    // {
    //     $data = [
    //         'name'        => $this->getProductName(),
    //         'description' => 'some_random_product_name',
    //     ];

    //     $this->json('post', '/product/create', $data, $this->getJwtHeader())
    //         ->seeJson(['status' => 'ok',]);

    //     $this->seeInDatabase('products', $data);
    // }

    // public function testUpdate()
    // {
    //     $product = $this->getProduct();

    //     $data = [
    //         'id' => $product->id,
    //         'name' => $product->name,
    //         'description'    => 'updated_random_product_description',
    //     ];

    //     $this->json('post', '/product/update', $data, $this->getJwtHeader())
    //         ->seeJson(['status' => 'ok',]);

    //     $this->seeInDatabase('products', $data);
    // }

    // public function testDelete()
    // {
    //     $product = $this->getProduct();

    //     $this->json('post', '/product/delete', ['id' => $product->id], $this->getJwtHeader())
    //         ->seeJson(['status' => 'ok',]);
    // }
}
