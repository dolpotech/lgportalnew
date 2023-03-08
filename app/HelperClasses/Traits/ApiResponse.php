<?php

namespace App\HelperClasses\Traits;

trait ApiResponse
{

    public function sendApiSuccessResponse($data = [], $message = '', $status = 1, $headers = []) {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status ? 'success' : 'error',
        ], 200, $headers);
    }

    public function sendApiErrorResponse($status, $message = '', $data = [], $headers = []) {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => 'error',
        ], $status, $headers);
    }

}
