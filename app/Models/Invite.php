<?php

namespace App\Models;

use App\Jobs\EstablishRelation;
use App\Models\Support\IdTrait;
use App\Models\Support\PersistTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Queues\Api\V1\Domain\RelationType;

class Invite extends Model
{
    use HasFactory, PersistTrait, IdTrait;

    public $table = 'invites';

    protected $primaryKey = 'invite_id';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'proposed_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'workspace_id', 'workspace_id');
    }

    public function getWorkspace(): Workspace
    {
        /** @var Workspace $workspace */
        $workspace = $this->workspace()->firstOrFail();
        return $workspace;
    }

    public function accept(string $collaboratorId): bool
    {
        EstablishRelation::dispatch($collaboratorId, $this->getWorkspace()->id, RelationType::MEMBER());
        return $this->delete();
    }

    public function discard(): bool
    {
        return $this->delete();
    }

}
