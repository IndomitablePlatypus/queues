<?php

namespace App\Models;

use App\Jobs\RequirementChanged;
use App\Jobs\RequirementsChanged;
use App\Models\Support\IdTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requirement extends Model
{
    use HasFactory, IdTrait;

    public $table = 'requirements';

    public $primaryKey = 'requirement_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'added_at' => 'datetime',
        'removed_at' => 'datetime',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'plan_id');
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        RequirementChanged::dispatch($this);
        return $this;
    }

    public function remove(): static
    {
        $this->removed_at = Carbon::now();
        RequirementsChanged::dispatch($this->plan);
        return $this;
    }

    public function persistInPlan(): Plan
    {
        $this->save();
        return $this->plan;
    }
}
