<?php

namespace App\Http\Controllers;

use App\Contracts\Permissions\Glob\GlobalGroupPermission;
use App\Entity\Group;
use App\Repository\GroupRepository;
use App\Service\Api\Api;
use App\Service\EntityService;
use Illuminate\Http\Request;


class GroupController extends AbstractController
{
    private $groups;
    private $service;

    public function __construct(GroupRepository $groups, EntityService $service)
    {
        $this->groups = $groups;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->check(GlobalGroupPermission::READ);

        list($total, $results) = $this->groups->search($request);

        return (new Api($request))
            ->setTotal($total)
            ->setCountable('groups', $results)
           ->build();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->check(GlobalGroupPermission::CREATE); 

        $group = new Group($request->except('permissions'));
        $group->user_id = $request->user()->getOwnerId();
        $group->save();

        $permissions = $request->input('permissions'); //TODO : refactor.

        if ( ! empty($permissions) && is_array($permissions))
        {
            $group->permissions()->sync($permissions);
        }

        return (new Api($request))
            ->set('id', $group->id)
            ->build();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->user()->check(GlobalGroupPermission::READ);
        
        $entitiy = $this->groups->getById($request->input('id'));

        return (new Api($request))
            ->set('group', $entitiy)
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
        $request->user()->check(GlobalGroupPermission::UPDATE);

        $entitiy = $this->groups->getById($request->input('id'));

        $entitiy = $this->service->updateEntity($entitiy, $request->except(['id', 'permissions']));

        $permissions = $request->input('permissions'); //TODO : refactor.

        if ( ! empty($permissions) && is_array($permissions))
        {
            $entitiy->permissions()->sync($permissions);
        }

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
        $request->user()->check(GlobalGroupPermission::DELETE);

        $entitiy = $this->groups->getById($request->input('id'));
        $this->service->deleteEntity($entitiy);

        return (new Api($request))
            ->build();
    }
}
