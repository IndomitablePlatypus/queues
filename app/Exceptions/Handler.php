<?php

namespace App\Exceptions;

use Codderz\Platypus\Exceptions\LogicException;
use Codderz\Platypus\Exceptions\ParameterAssertionException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\ItemNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): JsonResponse|Response
    {
        if ($e instanceof ItemNotFoundException) {
            return $this->errorResponse('Item Not Found', Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof ParameterAssertionException) {
            return $this->errorResponse('Wrong input: ' . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof LogicException) {
            return $this->errorResponse('Logic exception: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('Invalid method', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse('Not Found', Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof RouteNotFoundException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof HttpException) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        }

        if ($e instanceof AuthenticationException) {
            $message = $request->hasHeader('Authorization') ? 'Invalid access token' : 'Access token required';
            return $this->errorResponse($message, Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof QueryException && str_contains($e->getMessage(), 'personal_access_tokens')) {
            return $this->errorResponse('Unacceptable access token', Response::HTTP_UNAUTHORIZED);
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return $this->errorResponse('Unexpected Exception. Try later', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function errorResponse($message, int $code)
    {
        return response()->json(['message' => $message], $code);
    }

}
