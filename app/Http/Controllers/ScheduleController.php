<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Services\Schedule\ScheduleServiceContract;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\UnauthorizedException;

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
        } catch (UnauthorizedException $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['message' => $exception->getMessage()], $errorCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $this->scheduleService->deleteSchedule($schedule);
            return response()->json(['message' => 'Schedule canceled'], Response::HTTP_OK);
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['message' => $exception->getMessage()], $errorCode);
        }
    }
}
