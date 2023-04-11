<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
use App\Services\Advertiser\AdvertiserServiceContract;
use Exception;
use Illuminate\Http\Request;

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
            return response()->json($e->getMessage(), $e->getCode() ? $e->getCode() : 404);
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
