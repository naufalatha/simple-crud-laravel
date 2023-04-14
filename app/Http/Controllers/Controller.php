<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function respondWithData($data, $message = 'Success', int $statusCode = 200)
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function respondWithError($message, int $statusCode = 400)
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }

    protected function respondValidationError($data = [], $message = 'Validation Error!', $headers = [])
    {
        $result = [
            'status' => 'error',
            'status_code' => 400,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($result, 400, $headers);
    }
}
