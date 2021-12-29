<?php

namespace App\Models;

use App\Models\Support\IdTrait;
use App\Models\Support\PersistTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory, PersistTrait, IdTrait;

    public $table = 'requirements';

    public $primaryKey = 'requirement_id';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'added_at' => 'datetime',
        'removed_at' => 'datetime',
    ];

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function remove(): bool
    {
        return $this->delete();
    }
}
