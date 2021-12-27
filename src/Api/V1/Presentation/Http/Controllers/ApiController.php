<?php

namespace Queues\Api\V1\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function respond($response = 'Ok', int $code = 200): JsonResponse
    {
        return response()->json($response, $code);
    }

    protected function user(): User
    {
        return User::query()->findOrFail(Auth::id());
    }
}
