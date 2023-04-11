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
        } catch (ModelNotFoundException $e) {
            return response()->json($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            $errorCode = $e->getCode() ? $e->getCode() : Response::HTTP_NOT_FOUND;
            return response()->json($e->getMessage(), $errorCode);
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
        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode() ? $e->getCode() : 404);
        }
    }
}
