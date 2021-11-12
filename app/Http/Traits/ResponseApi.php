<?php

declare(strict_types=1);

namespace App\Http\Traits;

use \Illuminate\Http\JsonResponse;

trait ResponseApi
{
    protected function success($message = 'No message', $data = [], $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'success' => true,
            'data' => $data,
        ], $status);
    }

    protected function failure($message, $status = 422): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'success' => false,
        ], $status);
    }
}
