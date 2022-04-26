<?php

namespace App\Http\Controllers;

use App\Contracts\Permissions\ExceptionPermission;
use App\Contracts\Permissions\Glob\GlobalUserPermission;
use App\Entity\GroupUser;
use App\Entity\User;
use App\Events\UserRegisteredEvent;
use App\Exceptions\ClientException\PermissionException;
use App\Repository\GroupRepository;
use App\Repository\PermissionRepository;
use App\Repository\UserRepository;
use App\Service\Api\Api;
use App\Service\EntityService;
use App\Service\UserService;
use Faker\Generator;
use Illuminate\Http\Request;
use Predis\Client;

class UserController extends AbstractController
{
    private $users;
    private $service;
    private $groups;

    public function __construct(UserRepository $users, EntityService $service, GroupRepository $groups)
    {
        $this->users = $users;
        $this->service = $service;
        $this->groups = $groups;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Generator $faker, PermissionRepository $perm)
    {
        $request->user()->check(GlobalUserPermission::READ);

        $result = $this->users->getUsersForOwner($request, $request->user()->owner_id);

        return Api::fromSearch($result, $request, 'users');
    }

    public function create(Request $request)
    {
        $request->user()->check(GlobalUserPermission::CREATE);

        $user = new User($request->all());
        $user->owner_id = $request->user()->owner_id;
        $user = $this->service->createEntity($user);

        return (new Api($request))
            ->set('id', $user->id)
            ->build();
    }

    public function update(Request $request)
    {
        $request->user()->check(GlobalUserPermission::UPDATE);

        $user = $this->users->getById($request->input('id'));
        $this->service->updateEntity($user, $request->except('id')); //throws exception

        $this->updateGroup($user, $request->input('group_id'));

        return (new Api($request))
            ->build();
    }

    /**
     * Assign group to user.
     * 
     * @throws  GroupException if the group owner is not the user owner.
     */
    private function updateGroup($user, $group_id = null)
    {
        if ( ! empty($group_id))
        {
            $group = $this->groups->getById($group_id);

            if ($group->user_id !== $user->owner_id)
            {
                throw  PermissionException::badGroupOwner();
            }

            $group_user = new GroupUser;
            $group_user->user_id = $user->id;
            $group_user->group_id = $group->id;

            $user->group_user()->save($group_user);
        }
    }


    public function delete(Request $request)
    {
        $request->user()->check(GlobalUserPermission::DELETE);

        $user = $this->users->getById($request->input('id'));

        if ( ! $user->owner_id === $request->user()->owner_id)
        {
            throw PermissionException::badOwner();
        }

        $this->service->deleteEntity($user); //throws exception

        return (new Api($request))
            ->build();
    }
}