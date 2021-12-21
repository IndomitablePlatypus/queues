<?php

use Illuminate\Support\Facades\Route;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignInController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignOutController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignUpController;

Route::prefix(Routing::PREFIX_API)->middleware(Routing::MIDDLEWARE_API)->group(function () {
    Route::post(Routing::SIGN_UP)
        ->name(Routing::SIGN_UP)
        ->uses(SignUpController::class);

    Route::post(Routing::SIGN_IN)
        ->name(Routing::SIGN_IN)
        ->uses(SignInController::class);

    Route::get(Routing::SIGN_OUT)
        ->name(Routing::SIGN_OUT)
        ->middleware(Routing::MIDDLEWARE_AUTH)
        ->uses(SignOutController::class);

    Route::prefix(Routing::PREFIX_BUSINESS)->middleware(Routing::MIDDLEWARE_AUTH)->group(function() {

    });
});
