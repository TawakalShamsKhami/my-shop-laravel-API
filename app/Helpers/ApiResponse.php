<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function success($data, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], $code);
    }

    public static function error($status = 500, $message = null, $code = null)
    {
        $errors = [
            '404' => 'Resource not found',
            '403' => 'You do not have the required authorization.',
            '400' => 'Data you provided was invalid.',
            '500' => 'Internal server error.',
            '401' => 'Unauthorized.',
        ];

        return response()->json([
            'status' => 'error',
            'message' => $message ?: $errors[$status],
            'code' => $code ?: $status
        ], $status);
    }
}
