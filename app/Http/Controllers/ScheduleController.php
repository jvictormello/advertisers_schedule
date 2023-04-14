<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleFormRequest;
use App\Services\Schedule\ScheduleServiceContract;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->scheduleService->deleteSchedule($id);
            return response()->json(['message' => 'Schedule canceled'], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['message' => $exception->getMessage()], $errorCode);
        }
    }

    /**
     * Update schedule status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        try {
            $newStatus = $this->scheduleService->updateScheduleStatus($id);
            return response()->json(['message' => 'Schedule status updated to: "'.$newStatus.'"'], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['message' => $exception->getMessage()], $errorCode);
        }
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleFormRequest $request)
    {
        try {
            $request->validated();
            $message = $this->scheduleService->createSchedule();
            return response()->json($message, Response::HTTP_OK);
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['message' => $exception->getMessage()], $errorCode);
        }
    }
}
