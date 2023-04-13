<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Services\Schedule\ScheduleServiceContract;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleServiceContract $scheduleServiceContract)
    {
        $this->scheduleService = $scheduleServiceContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->validate(['date' => 'date_format:Y-m-d']);
            $filters = $request->only(['date', 'status', 'contractor_id']);
            return response()->json($this->scheduleService->getAllSchedulesByAdvertiserAndFilters($filters));
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['error' => $exception->getMessage()], $errorCode);
        }
    }

}
