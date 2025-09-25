<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse($message = 'Error', $code = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }
}

