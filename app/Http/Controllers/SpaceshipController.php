<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpaceshipService;
use Exception;
use App\Http\Requests\SpaceshipRequest;
use App\Http\Resources\SpaceshipResource;
use App\Http\Resources\SpaceshipCollectionResource;

class SpaceshipController extends BaseController
{
    /**
     * @var spaceshipService
     */
    protected $spaceshipService;

    /**
     * SpaceshipController Constructor
     *
     * @param SpaceshipService $spaceshipService
     *
     */
    public function __construct(SpaceshipService $spaceshipService)
    {
        $this->spaceshipService = $spaceshipService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->spaceshipService->getAll();

        return new SpaceshipCollectionResource($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SpaceshipRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpaceshipRequest $request)
    {
        $result = $this->spaceshipService->save($request->all());

        return isset($result['error']) ? $this->sendResponse($result['error']) : new SpaceshipResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->spaceshipService->getById($id);

        return isset($result['error']) ? $this->sendResponse($result['error']) : new SpaceshipResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SpaceshipRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpaceshipRequest $request, $id)
    {
        $result = $this->spaceshipService->update($request->all(), $id);

        return isset($result['error']) ? $this->sendResponse($result['error']) : new SpaceshipResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->spaceshipService->deleteById($id);
        
        return isset($result['error']) ? $this->sendResponse($result['error']) : $this->sendResponse($result);
    }
}
