<?php

namespace App\Http\Controllers;

use App\Contracts\Permissions\Glob\GlobalProductPermission;
use App\Contracts\Permissions\ProductPermission;
use App\Entity\BaseEntity;
use App\Entity\Product;
use App\Entity\User;
use App\Http\Requests;
use App\Repository\ProductRepository;
use App\Service\Api\Api;
use App\Service\EntityService;
use App\Validation\ProductValidation;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends AbstractController
{
    private $entities;
    private $service;

    public function __construct(ProductRepository $entities, EntityService $service)
    {
        $this->entities = $entities;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_id = $request->input('product_id');

        $request->user()->check(ProductPermission::READ, $product_id);

        $result = $this->entities->getProductsForUser($request, $request->user(), $product_id);

        return Api::fromSearch($result, $request, 'products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->check(GlobalProductPermission::CREATE);

        $entity = new Product($request->all());
        $entity->user_id = $request->user()->getOwnerId();
        $entity = $this->service->createEntity($entity);
        
        return (new Api($request))
            ->set('id', $entity->id)
            ->build();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->user()->check(ProductPermission::UPDATE);

        $entity = $this->entities->getById($request->input('id'));

        $this->service->updateEntity($entity, $request->except('id'));

        return (new Api($request))
            ->build();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $request->user()->check(ProductPermission::DELETE);

        $entity = $this->entities->getById($request->input('id'));
        $this->service->deleteEntity($entity);

        return (new Api($request))
            ->build();
    }
}
