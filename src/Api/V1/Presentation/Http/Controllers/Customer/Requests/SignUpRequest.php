<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'required',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute is required',
        ];
    }
}
