<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{
    use HasFactory;

    public $table = 'workspaces';

    protected $primaryKey = 'workspace_id';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'added_at' => 'datetime',
        'profile' => 'array',
    ];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function getIdAttribute(): string
    {
        return $this->workspace_id;
    }
}
