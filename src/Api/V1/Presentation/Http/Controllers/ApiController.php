<?php

namespace Queues\Api\V1\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function respond($response): JsonResponse
    {
        return response()->json($response);
    }
}
