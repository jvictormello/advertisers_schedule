<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Contracts\AdvertisersServiceContract;

class AdvertisersController extends Controller
{
    private $advertisersService;

    public function __construct(AdvertisersServiceContract $advertisersService)
    {
        $this->advertisersService = $advertisersService;
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
