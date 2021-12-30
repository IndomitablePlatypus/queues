<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards;

use Queues\Api\V1\Presentation\Http\Controllers\ApiController;
use Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests\NoteAchievementRequest;

class NoteAchievementController extends ApiController
{
    public function __invoke(NoteAchievementRequest $request)
    {
        return $this->respond(
            $this
                ->user()
                ->getWorkspace($request->workspaceId)
                ->getCard($request->cardId)
                ->noteAchievement($request->achievementId, $request->description)
                ->persist()
        );
    }
}
