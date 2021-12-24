<?php

use Illuminate\Support\Facades\Route;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignInController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignOutController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignUpController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\WorkspacesAllController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\WorkspacesAddController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\WorkspacesChangeProfileController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\WorkspacesGetController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\WorkspacesGetOneController;

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

    Route::get(Routing::WORKSPACES_ALL)
        ->name(Routing::WORKSPACES_ALL)
        ->uses(WorkspacesAllController::class);

    Route::group(['middleware' => Routing::MIDDLEWARE_AUTH], function() {
        Route::get(Routing::WORKSPACES_GET)
            ->name(Routing::WORKSPACES_GET)
            ->uses(WorkspacesGetController::class);

        Route::get(Routing::WORKSPACES_GET_ONE)
            ->name(Routing::WORKSPACES_GET_ONE)
            ->uses(WorkspacesGetOneController::class);

        Route::post(Routing::WORKSPACES_ADD)
            ->name(Routing::WORKSPACES_ADD)
            ->uses(WorkspacesAddController::class);

        Route::put(Routing::WORKSPACES_CHANGE_PROFILE)
            ->name(Routing::WORKSPACES_CHANGE_PROFILE)
            ->uses(WorkspacesChangeProfileController::class);
    });
});
