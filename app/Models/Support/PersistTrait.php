<?php

namespace App\Models\Support;

trait PersistTrait
{
    public function persist(): static
    {
        $this->save();
        return $this;
    }
}
