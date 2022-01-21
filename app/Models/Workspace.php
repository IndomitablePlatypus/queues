<?php

namespace App\Models;

use App\Jobs\CeaseRelation;
use App\Jobs\EstablishRelation;
use App\Models\Support\IdTrait;
use App\Models\Support\PersistTrait;
use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Queues\Api\V1\Domain\RelationType;

class Workspace extends Model
{
    use HasFactory, PersistTrait, IdTrait;

    public $table = 'workspaces';

    protected $primaryKey = 'workspace_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'added_at' => 'datetime',
        'profile' => 'array',
    ];

    public function relateTo(string $collaboratorId, RelationType $relationType): static
    {
        EstablishRelation::dispatch($collaboratorId, $this->id, $relationType);
        return $this;
    }

    public function fire(string $collaboratorId): bool
    {
        CeaseRelation::dispatch($collaboratorId, $this->id, RelationType::MEMBER());
        return true;
    }

    public function leave(string $collaboratorId): bool
    {
        CeaseRelation::dispatch($collaboratorId, $this->id, RelationType::MEMBER());
        return true;
    }

    public function relations(): HasMany
    {
        return $this->hasMany(Relation::class, 'workspace_id', 'workspace_id');
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class, 'workspace_id', 'workspace_id');
    }

    public function invite(): Invite
    {
        /** @var Invite $invite */
        $invite = $this->invites()->create([
            'invite_id' => GuidBasedImmutableId::makeValue(),
            'proposed_at' => Carbon::now(),
        ]);
        return $invite;
    }

    public function getInvite(string $id): Invite
    {
        /** @var Invite $invite */
        $invite = $this->invites()->where('invite_id', '=', $id)->firstOrFail();
        return $invite;
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class, 'workspace_id', 'workspace_id');
    }

    public function cards(): HasManyThrough
    {
        return $this->hasManyThrough(Card::class, Plan::class, 'workspace_id', 'plan_id', 'workspace_id', 'plan_id');
    }

    public function getPlans(): Collection
    {
        return $this->plans()->get();
    }

    public function getPlan(string $id): Plan
    {
        /** @var Plan $plan */
        $plan = $this->plans()->where('plan_id', '=', $id)->firstOrFail();
        return $plan;
    }

    public function addPlan(string $name, string $description): Plan
    {
        /** @var Plan $plan */
        $plan = $this->plans()->create([
            'plan_id' => GuidBasedImmutableId::makeValue(),
            'profile' => ['name' => $name, 'description' => $description],
            'workspace_id' => $this->id,
        ]);
        return $plan;
    }

    public function getCard(string $id): Card
    {
        /** @var Card $card */
        $card = $this->cards()->where('card_id', '=', $id)->firstOrFail();
        return $card;
    }
}
