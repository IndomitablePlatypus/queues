<?php

use Illuminate\Support\Facades\Route;
use Queues\Api\V1\Config\Routing\RouteName;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\CardsBlockController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\CardsCompleteController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\CardsGetOneController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\CardsIssueController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\CardsRevokeController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\CardsUnblockController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\CardsAchievementDismissController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\CardsAchievementNoteController;
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
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansArchiveController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansChangeProfileController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansGetController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansGetOneController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansLaunchController;
use Queues\Api\V1\Presentation\Http\Controllers\Plans\PlansStopController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\RequirementsAddController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\RequirementsChangeController;
use Queues\Api\V1\Presentation\Http\Controllers\Requirements\RequirementsRemoveController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\WorkspacesAddController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\WorkspacesChangeProfileController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\WorkspacesGetController;
use Queues\Api\V1\Presentation\Http\Controllers\Workspaces\WorkspacesGetOneController;

Route::prefix(Routing::PREFIX_API)->middleware(Routing::MIDDLEWARE_API)->group(function () {
    Route::post(Routing::uri(RouteName::REGISTER))
        ->name(RouteName::REGISTER)
        ->uses(SignUpController::class);

    Route::post(Routing::uri(RouteName::GET_TOKEN))
        ->name(RouteName::GET_TOKEN)
        ->uses(SignInController::class);

    Route::get(Routing::uri(RouteName::CUSTOMER_WORKSPACES))
        ->name(RouteName::CUSTOMER_WORKSPACES)
        ->uses(WorkspacesAllController::class);

    Route::group(['middleware' => Routing::MIDDLEWARE_AUTH], function () {
        Route::get(Routing::uri(RouteName::CLEAR_TOKENS))
            ->name(RouteName::CLEAR_TOKENS)
            ->uses(SignOutController::class);

        Route::get(Routing::uri(RouteName::CUSTOMER_CARDS))
            ->name(RouteName::CUSTOMER_CARDS)
            ->uses(WorkspacesAllController::class);

        Route::get(Routing::uri(RouteName::CUSTOMER_CARD))
            ->name(RouteName::CUSTOMER_CARD)
            ->uses(WorkspacesAllController::class);

        Route::get(Routing::uri(RouteName::GET_WORKSPACES))
            ->name(RouteName::GET_WORKSPACES)
            ->uses(WorkspacesGetController::class);

        Route::get(Routing::uri(RouteName::GET_WORKSPACE))
            ->name(RouteName::GET_WORKSPACE)
            ->uses(WorkspacesGetOneController::class);

        Route::post(Routing::uri(RouteName::ADD_WORKSPACE))
            ->name(RouteName::ADD_WORKSPACE)
            ->uses(WorkspacesAddController::class);

        Route::put(Routing::uri(RouteName::CHANGE_PROFILE))
            ->name(RouteName::CHANGE_PROFILE)
            ->uses(WorkspacesChangeProfileController::class);

        Route::post(Routing::uri(RouteName::PROPOSE_INVITE))
            ->name(RouteName::PROPOSE_INVITE)
            ->uses(InviteProposeController::class);

        Route::put(Routing::uri(RouteName::ACCEPT_INVITE))
            ->name(RouteName::ACCEPT_INVITE)
            ->uses(InviteAcceptController::class);

        Route::delete(Routing::uri(RouteName::DISCARD_INVITE))
            ->name(RouteName::DISCARD_INVITE)
            ->uses(InviteDiscardController::class);

        Route::post(Routing::uri(RouteName::LEAVE_RELATION))
            ->name(RouteName::LEAVE_RELATION)
            ->uses(CollaborationLeaveController::class);

        Route::post(Routing::uri(RouteName::FIRE_COLLABORATOR))
            ->name(RouteName::FIRE_COLLABORATOR)
            ->uses(CollaborationFireController::class);

        Route::get(Routing::uri(RouteName::GET_PLANS))
            ->name(RouteName::GET_PLANS)
            ->uses(PlansGetController::class);

        Route::get(Routing::uri(RouteName::GET_PLAN))
            ->name(RouteName::GET_PLAN)
            ->uses(PlansGetOneController::class);

        Route::post(Routing::uri(RouteName::ADD_PLAN))
            ->name(RouteName::ADD_PLAN)
            ->uses(PlansAddController::class);

        Route::put(Routing::uri(RouteName::CHANGE_PLAN_PROFILE))
            ->name(RouteName::CHANGE_PLAN_PROFILE)
            ->uses(PlansChangeProfileController::class);

        Route::put(Routing::uri(RouteName::LAUNCH_PLAN))
            ->name(RouteName::LAUNCH_PLAN)
            ->uses(PlansLaunchController::class);

        Route::put(Routing::uri(RouteName::STOP_PLAN))
            ->name(RouteName::STOP_PLAN)
            ->uses(PlansStopController::class);

        Route::put(Routing::uri(RouteName::ARCHIVE_PLAN))
            ->name(RouteName::ARCHIVE_PLAN)
            ->uses(PlansArchiveController::class);

        Route::post(Routing::uri(RouteName::ADD_PLAN_REQUIREMENT))
            ->name(RouteName::ADD_PLAN_REQUIREMENT)
            ->uses(RequirementsAddController::class);

        Route::put(Routing::uri(RouteName::CHANGE_PLAN_REQUIREMENT))
            ->name(RouteName::CHANGE_PLAN_REQUIREMENT)
            ->uses(RequirementsChangeController::class);

        Route::delete(Routing::uri(RouteName::REMOVE_PLAN_REQUIREMENT))
            ->name(RouteName::REMOVE_PLAN_REQUIREMENT)
            ->uses(RequirementsRemoveController::class);

        Route::get(Routing::uri(RouteName::GET_CARD))
            ->name(RouteName::GET_CARD)
            ->uses(CardsGetOneController::class);

        Route::post(Routing::uri(RouteName::ISSUE_CARD))
            ->name(RouteName::ISSUE_CARD)
            ->uses(CardsIssueController::class);

        Route::put(Routing::uri(RouteName::COMPLETE_CARD))
            ->name(RouteName::COMPLETE_CARD)
            ->uses(CardsCompleteController::class);

        Route::put(Routing::uri(RouteName::REVOKE_CARD))
            ->name(RouteName::REVOKE_CARD)
            ->uses(CardsRevokeController::class);

        Route::put(Routing::uri(RouteName::BLOCK_CARD))
            ->name(RouteName::BLOCK_CARD)
            ->uses(CardsBlockController::class);

        Route::put(Routing::uri(RouteName::UNBLOCK_CARD))
            ->name(RouteName::UNBLOCK_CARD)
            ->uses(CardsUnblockController::class);

        Route::post(Routing::uri(RouteName::NOTE_ACHIEVEMENT))
            ->name(RouteName::NOTE_ACHIEVEMENT)
            ->uses(CardsAchievementNoteController::class);

        Route::delete(Routing::uri(RouteName::DISMISS_ACHIEVEMENT))
            ->name(RouteName::DISMISS_ACHIEVEMENT)
            ->uses(CardsAchievementDismissController::class);
    });
});
