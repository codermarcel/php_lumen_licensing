<?php

namespace App\Http\Controllers;

use App\Repository\PermissionRepository;
use App\Service\Api\Api;
use Illuminate\Http\Request;

class PermissionController extends AbstractController
{
    private $service;

    public function __construct(PermissionRepository $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$request->user()->check(GlobalGroupPermission::READ); TODO : do you need permissions?

        list($total, $results) = $this->permissions->search($request);

        return (new Api($request))
            ->setTotal($total)
            ->setCountable('permissions', $results)
            ->build();
    }

    
}
