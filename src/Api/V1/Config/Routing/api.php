<?php

use Illuminate\Support\Facades\Route;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\CollaborationFireController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\CollaborationLeaveController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\InviteAcceptController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\InviteDiscardController;
use Queues\Api\V1\Presentation\Http\Controllers\Collaboration\InviteProposeController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignInController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignOutController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\SignUpController;
use Queues\Api\V1\Presentation\Http\Controllers\Customer\WorkspacesAllController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansAddController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansChangeDescriptionController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansGetController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansGetOneController;
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


        Route::post(Routing::INVITE_PROPOSE)
            ->name(Routing::INVITE_PROPOSE)
            ->uses(InviteProposeController::class);

        Route::put(Routing::INVITE_ACCEPT)
            ->name(Routing::INVITE_ACCEPT)
            ->uses(InviteAcceptController::class);

        Route::delete(Routing::INVITE_DISCARD)
            ->name(Routing::INVITE_DISCARD)
            ->uses(InviteDiscardController::class);


        Route::post(Routing::COLLABORATION_LEAVE)
            ->name(Routing::COLLABORATION_LEAVE)
            ->uses(CollaborationLeaveController::class);

        Route::post(Routing::COLLABORATION_FIRE)
            ->name(Routing::COLLABORATION_FIRE)
            ->uses(CollaborationFireController::class);


        Route::get(Routing::PLANS_GET)
            ->name(Routing::PLANS_GET)
            ->uses(PlansGetController::class);

        Route::get(Routing::PLANS_GET_ONE)
            ->name(Routing::PLANS_GET_ONE)
            ->uses(PlansGetOneController::class);

        Route::post(Routing::PLANS_ADD)
            ->name(Routing::PLANS_ADD)
            ->uses(PlansAddController::class);

        Route::put(Routing::PLANS_CHANGE_DESCRIPTION)
            ->name(Routing::PLANS_CHANGE_DESCRIPTION)
            ->uses(PlansChangeDescriptionController::class);

    });
});
