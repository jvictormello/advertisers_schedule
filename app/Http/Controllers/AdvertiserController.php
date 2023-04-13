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
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['error' => $exception->getMessage()], $errorCode);
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
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['error' => $exception->getMessage()], $errorCode);
        }
    }

    /**
     * Just a test endpoint.
     *
     * @return \Illuminate\Http\Response
     */
    public function test() {
        try {
            return response()->json(['response' => 'OK'], Reponse::HTTP_OK);
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['error' => $exception->getMessage()], $errorCode);
        }
    }
}
