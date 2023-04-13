<?php

namespace App\Http\Controllers;

use App\Services\Authentication\AuthenticationServiceContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    protected $authenticationService;

    public function __construct(AuthenticationServiceContract $authenticationServiceContract)
    {
        $this->authenticationService = $authenticationServiceContract;
    }

    /**
     * Login Advertiser.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginAdvertiser(Request $request) {
        try {
            $credentials = $request->only('login', 'password');
            $auth = $this->authenticationService->loginAdvertiser($credentials);

            return response()->json($auth, Response::HTTP_OK);
        } catch (UnauthorizedException $exception) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['error' => $exception->getMessage()], $errorCode);
        }
    }

    /**
     * Login Contractor.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginContractor(Request $request) {
        try {
            $credentials = $request->only('login', 'password');
            $auth = $this->authenticationService->loginContractor($credentials);

            return response()->json($auth, Response::HTTP_OK);
        } catch (UnauthorizedException $exception) {
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        } catch (Exception $exception) {
            $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json(['error' => $exception->getMessage()], $errorCode);
        }
    }
}
