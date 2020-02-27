<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Success response method
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'muessafe' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * Return error response
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => true,
            'message' =>$error
        ];

        if (!empty($errorMessage)){
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }
}
