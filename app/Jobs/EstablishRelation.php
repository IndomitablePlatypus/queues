<?php

namespace App\Jobs;

use App\Models\Relation;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Queues\Api\V1\Domain\RelationType;

class EstablishRelation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $timeout = 60;
    public int $backoff = 5;

    public function __construct(
        protected string $userId,
        protected string $workspaceId,
        protected RelationType $relationType,
    ) {
    }

    public function handle(): void
    {
        Log::info(sprintf('EstablishRelation: user %s, type: %s INIT', $this->userId, $this->relationType));

        $relation = new Relation([
            'relation_id' => GuidBasedImmutableId::make(),
            'collaborator_id' => $this->userId,
            'workspace_id' => $this->workspaceId,
            'relation_type' => (string) $this->relationType,
            'established_at' => Carbon::now(),
        ]);
        $relation->saveOrFail();
        Log::info(sprintf('EstablishRelation: user %s, type: %s SUCCESS', $this->userId, $this->relationType));
    }
}
