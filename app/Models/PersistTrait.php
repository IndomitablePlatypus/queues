<?php

namespace App\Models;

trait PersistTrait
{
    public function persist(): static
    {
        $this->save();
        return $this;
    }
}
