<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{
    use HasFactory, PersistTrait;

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

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class, 'workspace_id', 'workspace_id');
    }

    public function getIdAttribute(): string
    {
        return $this->workspace_id;
    }

    public function invite(): Invite
    {
        /** @var Invite $invite */
        $invite = $this->invites()->create([
            'collaborator_id' => $this->keeper_id,
        ]);
        return $invite;
    }

    public function getInvite(string $id): Invite
    {
        /** @var Invite $invite */
        $invite = $this->invites()->where('invite_id', '=', $id)->firstOrFail();
        return $invite;
    }
}
