<?php

namespace App\Models;

use App\Jobs\RequirementsChanged;
use App\Models\Support\IdTrait;
use App\Models\Support\PersistTrait;
use Carbon\Carbon;
use Codderz\Platypus\Exceptions\LogicException;
use Codderz\Platypus\Exceptions\ParameterAssertionException;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Throwable;

class Plan extends Model
{
    use HasFactory, PersistTrait, IdTrait;

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
        'profile' => 'array',
    ];

    public static function compactRequirements(array $requirements): array
    {
        $compact = [];
        foreach ($requirements as $requirement) {
            $compact[] = ['requirementId' => $requirement['requirement_id'], 'description' => $requirement['description']];
        }
        return $compact;
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'workspace_id', 'workspace_id');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'plan_id', 'plan_id');
    }

    public function getCards(): Collection
    {
        return $this->cards()->get();
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class, 'plan_id', 'plan_id')->whereNull('removed_at');
    }

    public function getRequirements(): Collection
    {
        return $this->requirements()->get();
    }

    public function addRequirement(string $description): Requirement
    {
        /** @var Requirement $requirement */
        $requirement = $this->requirements()->create([
            'requirement_id' => GuidBasedImmutableId::makeValue(),
            'description' => $description,
            'added_at' => Carbon::now(),
        ]);
        RequirementsChanged::dispatch($this);
        return $requirement;
    }

    public function getRequirement(string $id): Requirement
    {
        /** @var Requirement $requirement */
        $requirement = $this->requirements()->where('requirement_id', '=', $id)->firstOrFail();
        return $requirement;
    }

    public function setProfile(string $name, string $description): static
    {
        $this->profile = ['name' => $name, 'description' => $description];
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

    public function issueCard(string $customerId): Card
    {
        /** @var Card $card */
        $card = $this->cards()->create([
            'card_id' => GuidBasedImmutableId::makeValue(),
            'customer_id' => $customerId,
            'description' => $this->profile['description'],
            'issued_at' => Carbon::now(),
            'requirements' => static::compactRequirements($this->getRequirements()->toArray()),
        ]);
        return $card;
    }
}
