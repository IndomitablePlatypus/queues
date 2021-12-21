<?php

use Illuminate\Support\Facades\Route;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignInController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignUpController;

Route::prefix(Routing::PREFIX)->middleware(Routing::MIDDLEWARE)->group(function () {
    Route::post(Routing::SIGN_UP)
        ->name(Routing::SIGN_UP)
        ->uses(SignUpController::class);

    Route::post(Routing::SIGN_IN)
        ->name(Routing::SIGN_IN)
        ->uses(SignInController::class);
});
