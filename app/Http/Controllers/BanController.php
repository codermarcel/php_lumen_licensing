<?php

namespace App\Http\Controllers;

use App\Contracts\Permissions\BanPermission;
use App\Entity\Ban;
use App\Http\Requests;
use App\Repository\BanRepository;
use App\Service\Api\Api;
use App\Service\EntityService;
use Illuminate\Http\Request;

class BanController extends AbstractController
{
    private $bans;
    private $service;

    public function __construct(BanRepository $bans, EntityService $service)
    {
        $this->bans = $bans;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->check(BanPermission::READ);

        list($total, $results) = $this->bans->search($request);

        return (new Api($request))
            ->setTotal($total)
            ->setCountable('bans', $results)
            ->build();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->check(BanPermission::CREATE);

        $ban = new Ban($request->all());
        $ban->setAutoValidate(false);
        //$ban->issuer_id = $request->user()->getOwnerId();
        $ban->save();

        return (new Api($request))
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
        $request->user()->check(BanPermission::UPDATE);

        $ban = $this->bans->getById($request->input('id'));

        $ban = $this->service->updateEntity($ban, $request->except('id'));

        return (new Api($request))
            ->build();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->user()->check(BanPermission::DELETE);

        $ban = $this->bans->getById($request->input('id'));
        $this->service->deleteEntity($ban);

        return (new Api($request))
            ->build();
    }
}
