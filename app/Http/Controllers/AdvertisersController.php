<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Contracts\AdvertisersServiceContract;
use App\Services\Contracts\AvailabilitiesServiceContract;

class AdvertisersController extends Controller
{
    private $advertisersService;
    private $availabilitiesService;

    public function __construct(
        AdvertisersServiceContract $advertisersService,
        AvailabilitiesServiceContract $availabilitiesService
    ) {
        $this->advertisersService = $advertisersService;
        $this->availabilitiesService = $availabilitiesService;
    }

    /**
     * Display a listing of advertisers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try {
            return new JsonResponse($this->advertisersService->search($request));
        } catch(\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Display an advertiser.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(?int $id = null): JsonResponse
    {
        $searchRequest = new Request(['query' => json_encode(['id' => $id])]);
        return $this->list($searchRequest);
    }

    /**
     * Display a listing of advertiser availabilities.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAvailabilities(?int $id = null): JsonResponse
    {
        try {
            return new JsonResponse($this->availabilitiesService->searchByAdvertiserId($id));
        } catch(\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Display an especific advertiser availability.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewAvailabilities(?int $id = null): JsonResponse
    {
        try {
            return new JsonResponse($this->availabilitiesService->searchByAvailabilityId($id));
        } catch(\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Display an error.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse(\Exception $e): JsonResponse
    {
        return new JsonResponse(
            ['error' => $e->getMessage()],
            ($e->getCode() == 0 || !$e->getCode())?500:$e->getCode()
        );
    }
}
