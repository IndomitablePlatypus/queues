<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests;

use Queues\Api\V1\Presentation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    public string $username;

    public string $password;

    public function rules(): array
    {
        return [
            'username' => 'required',
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
