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

}
