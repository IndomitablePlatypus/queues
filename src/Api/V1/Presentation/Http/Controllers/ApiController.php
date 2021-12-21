<?php

namespace Queues\Api\V1\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function respond($response, int $code = 200): JsonResponse
    {
        return response()->json($response, $code);
    }
}
