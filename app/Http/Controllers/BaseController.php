<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($message, $data = null, $code = 200)
    {
        if (is_array($message)) {
            $response = [
                'message' => $message[0]
            ];

            if (isset($message[1])) {
                $response = array_merge($response, ['data' => $message[1]]);
            }

            if (isset($message[2])) {
                $code = $message[2];
            }
        } else {
            $response = [
                'message' => $message
            ];

            if (!empty($data)) {
                $response = array_merge($response, ['data' => $data]);
            }
        }

        return response()->json($response, $code);
    }
}
