<?php

namespace App\Models;

use App\Models\Support\IdTrait;
use App\Models\Support\PersistTrait;
use Carbon\Carbon;
use Codderz\Platypus\Exceptions\LogicException;
use Codderz\Platypus\Exceptions\ParameterAssertionException;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Throwable;

class Plan extends Model
{
    use HasFactory, PersistTrait, IdTrait, ArrayPresenterTrait;

    public $table = 'plans';

    public $primaryKey = 'plan_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $with = ['requirements'];

    protected $casts = [
        'added_at' => 'datetime',
        'launched_at' => 'datetime',
        'stopped_at' => 'datetime',
        'archived_at' => 'datetime',
        'expiration_date' => 'datetime',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'workspace_id', 'workspace_id');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'plan_id', 'plan_id');
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class, 'plan_id', 'plan_id');
    }

    public function addRequirement(string $description): Requirement
    {
        /** @var Requirement $requirement */
        $requirement = $this->requirements()->create([
            'requirement_id' => GuidBasedImmutableId::makeValue(),
            'description' => $description,
            'added_at' => Carbon::now(),
        ]);
        return $requirement;
    }

    public function getRequirement(string $id): Requirement
    {
        /** @var Requirement $requirement */
        $requirement = $this->requirements()->where('requirement_id', '=', $id)->firstOrFail();
        return $requirement;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function launch(string $expirationDate): static
    {
        if ($this->archived_at) {
            throw new LogicException('Cannot launch archived plan');
        }
        try {
            $this->expiration_date = new Carbon($expirationDate);
        } catch (Throwable) {
            throw new ParameterAssertionException("Expiration date should be valid date");
        }

        $this->launched_at = Carbon::now();
        $this->stopped_at = null;
        return $this;
    }

    public function stop(): static
    {
        if ($this->archived_at) {
            throw new LogicException('Cannot stop archived plan');
        }
        $this->stopped_at = Carbon::now();
        $this->launched_at = null;
        $this->expiration_date = null;
        return $this;
    }

    public function archive(): static
    {
        $this->archived_at = Carbon::now();
        return $this;
    }
}
