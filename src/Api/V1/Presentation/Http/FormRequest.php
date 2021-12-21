<?php

namespace Queues\Api\V1\Presentation\Http;

use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;

class FormRequest extends IlluminateFormRequest
{
    use ArrayPresenterTrait;

    public function passedValidation()
    {
        foreach ($this->input() as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public function toArray(): array
    {
        return $this->_toArray(true, true);
    }
}
