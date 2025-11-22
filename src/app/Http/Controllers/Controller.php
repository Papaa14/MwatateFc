<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class  Controller
{
    /**
     * Success response method
     */
    public function sendResponse($result, $message = 'Operation completed successfully'): JsonResponse
    {
        $response = [
            'success' => true,
            'status' => 'success',
            'message' => $message,
            'data' => $result,
            'error' => null
        ];

        return response()->json($response, 200);
    }

    /**
     * Error response method
     */
    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'status' => 'error',
            'message' => $error,
            'data' => null,
            'error' => $errorMessages
        ];

        return response()->json($response, $code);
    }
}
