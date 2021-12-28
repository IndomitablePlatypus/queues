<?php

namespace App\Models\Support;

trait IdTrait
{
    public function getIdAttribute(): string
    {
        return $this->{$this->primaryKey};
    }
}
