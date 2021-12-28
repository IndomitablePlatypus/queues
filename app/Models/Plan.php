<?php

namespace App\Models;

use App\Models\Support\IdTrait;
use App\Models\Support\PersistTrait;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory, PersistTrait, IdTrait, ArrayPresenterTrait;

    public $table = 'plans';

    public $primaryKey = 'plan_id';

    public $incrementing = false;

    protected $guarded = [];

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
        return $this->hasMany(Card::class);
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class);
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }
}
