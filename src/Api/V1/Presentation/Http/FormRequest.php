<?php

namespace Queues\Api\V1\Presentation\Http;

use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;

class FormRequest extends IlluminateFormRequest
{
    use ArrayPresenterTrait {
        ArrayPresenterTrait::toArray as __toArray;
    }

    public function passedValidation()
    {
        foreach ($this->input() as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public function toArray(): array
    {
        return $this->__toArray(true, true);
    }
}
