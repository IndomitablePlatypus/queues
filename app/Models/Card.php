<?php

namespace App\Models;

use App\Models\Support\IdTrait;
use App\Models\Support\PersistTrait;
use Carbon\Carbon;
use Codderz\Platypus\Exceptions\LogicException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory, PersistTrait, IdTrait;

    public $table = 'cards';

    public $primaryKey = 'card_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'issued_at' => 'datetime',
        'satisfied_at' => 'datetime',
        'completed_at' => 'datetime',
        'revoked_at' => 'datetime',
        'blocked_at' => 'datetime',
        'achievements' => 'array',
        'requirements' => 'array',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'plan_id');
    }

    public function workspace(): Workspace
    {
        return $this->plan->workspace;
    }

    public function isSatisfied(): bool
    {
        return $this->satisfied_at !== null;
    }

    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }

    public function isRevoked(): bool
    {
        return $this->revoked_at !== null;
    }

    public function isBlocked(): bool
    {
        return $this->blocked_at !== null;
    }

    public function complete(): static
    {
        if ($this->isCompleted() || $this->isRevoked() || $this->isBlocked()) {
            throw new LogicException('Invalid card state');
        }

        $this->completed_at = Carbon::now();
        return $this;
    }

    public function revoke(): static
    {
        if ($this->isRevoked() || $this->isCompleted()) {
            throw new LogicException('Invalid card state');
        }

        $this->revoked_at = Carbon::now();
        return $this;
    }

    public function block(): static
    {
        if ($this->isBlocked() || $this->isCompleted() || $this->isRevoked()) {
            throw new LogicException('Invalid card state');
        }

        $this->blocked_at = Carbon::now();
        return $this;
    }

    public function unblock(): static
    {
        if (!$this->isBlocked() || $this->isRevoked()) {
            throw new LogicException('Invalid card state');
        }

        $this->blocked_at = null;
        return $this;
    }

    public function noteAchievement(string $id, string $description): static
    {
        if ($this->isSatisfied() || $this->isCompleted() || $this->isBlocked() || $this->isRevoked()) {
            throw new LogicException('Invalid card state');
        }
        $achievements = $this->achievements ?? [];
        $achievements[] = ['achievementId' => $id, 'description' => $description];
        $this->achievements = $achievements;
        return $this->tryToSatisfy();
    }

    public function dismissAchievement(string $id): static
    {
        if ($this->isCompleted() || $this->isBlocked() || $this->isRevoked()) {
            throw new LogicException('Invalid card state');
        }
        $achievements = $this->achievements ?? [];
        foreach ($achievements as $key => $achievement) {
            if ($achievement['achievementId'] === $id) {
                unset($achievements[$key]);
            }
        }
        $this->achievements = $achievements;
        return $this->tryToWithdrawSatisfaction();
    }

    public function fixRequirementDescription(string $id, string $description): static
    {
        $achievements = $this->achievements ?? [];
        foreach ($achievements as $key => $achievement) {
            if ($achievement['achievementId'] === $id) {
                $achievements[$key]['description'] = $description;
            }
        }
        $this->achievements = $achievements;

        $requirements = $this->requirements ?? [];
        foreach ($requirements as $key => $requirement) {
            if ($requirement['requirementId'] === $id) {
                $requirements[$key]['description'] = $description;
            }
        }
        $this->requirements = $requirements;
        return $this;
    }

    public function acceptRequirements(array $requirements): static
    {
        $this->requirements = $requirements;
        return $this->tryToSatisfy();
    }

    public function getIssuedCardRepresentation(): array
    {
        return [
            'cardId' => $this->card_id,
            'workspaceName' => $this->workspace->name,
            'workspaceAddress' => $this->workspace->address,
            'customerId' => $this->customer_id,
            'description' => $this->description,
            'satisfied' => $this->satisfied_at !== null,
            'completed' => $this->completed_at !== null,
            'achievements' => $this->achievements,
            'requirements' => $this->requirements,
        ];
    }

    public function getBusinessCardRepresentation(): array
    {
        return [
            'cardId' => $this->card_id,
            'planId' => $this->plan_id,
            'customerId' => $this->customer_id,
            'isIssued' => $this->issued_at !== null,
            'isSatisfied' => $this->satisfied_at !== null,
            'isCompleted' => $this->completed_at !== null,
            'isRevoked' => $this->revoked_at !== null,
            'isBlocked' => $this->blocked_at !== null,
            'achievements' => $this->achievements,
            'requirements' => $this->requirements,
        ];
    }

    private function tryToSatisfy(): static
    {
        $requirements = $this->requirements;
        foreach ($this->achievements as $achievement) {
            foreach ($requirements as $key => $requirement) {
                if ($requirement['requirementId'] === $achievement['achievementId']) {
                    unset($requirements[$key]);
                }
            }
        }
        if (empty($requirements)) {
            $this->satisfied_at = Carbon::now();
        }
        return $this;
    }

    private function tryToWithdrawSatisfaction(): static
    {
        if (!$this->isSatisfied()) {
            return $this;
        }

        $requirements = $this->requirements;
        foreach ($this->achievements as $achievement) {
            foreach ($requirements as $key => $requirement) {
                if ($requirement['requirementId'] === $achievement['achievementId']) {
                    unset($requirements[$key]);
                }
            }
        }
        if (!empty($requirements)) {
            $this->satisfied_at = null;
        }

        return $this;
    }
}
