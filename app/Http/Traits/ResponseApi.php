<?php

declare(strict_types=1);

namespace App\Http\Traits;

use \Illuminate\Http\JsonResponse;

trait ResponseApi
{
    protected function success($data = [], $status = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'code' => $status,
        ], $status);
    }

    protected function failure($message, $status = 422): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $status,
        ], $status);
    }
}
