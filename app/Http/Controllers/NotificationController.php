<?php

namespace App\Http\Controllers;

use App\Services\Notification\NotificationServiceContract;
use Exception;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationServiceContract $notificationServiceContract)
    {
        $this->notificationService = $notificationServiceContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json($this->notificationService->getAllNotifications());
        } catch (UnauthorizedException $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['message' => $exception->getMessage()], $errorCode);
        }
    }
}
