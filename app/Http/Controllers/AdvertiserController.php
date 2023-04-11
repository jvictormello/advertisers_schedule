<?php

namespace App\Http\Controllers;

use App\Services\Advertiser\AdvertiserServiceContract;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AdvertiserController extends Controller
{
    protected $advertiserService;

    public function __construct(AdvertiserServiceContract $advertiserServiceContract)
    {
        $this->advertiserService = $advertiserServiceContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json($this->advertiserService->getAllCachedAdvertisers());
        } catch (Exception $e) {
            $errorCode = $e->getCode() ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['error' => $e->getMessage()], $errorCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return response()->json($this->advertiserService->getCachedAdvertiserById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $errorCode = $e->getCode() ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['error' => $e->getMessage()], $errorCode);
        }
    }
}
