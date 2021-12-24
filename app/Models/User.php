<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'registration_initiated_at' => 'datetime',
    ];

    public static function findByCredentialsOrFail(string $username, string $password): static
    {
        $user = User::query()
            ->where('username', $username)
            ->firstOrFail();

        if (!Hash::check($password, $user->password)) {
            throw new Exception('Unknown credentials');
        }

        return $user;
    }

    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class, 'relations', 'collaborator_id', 'workspace_id');
    }

    public function workspace(string $id): BelongsToMany
    {
        return $this->workspaces()->where('workspaces.workspace_id', '=', $id);
    }

}
