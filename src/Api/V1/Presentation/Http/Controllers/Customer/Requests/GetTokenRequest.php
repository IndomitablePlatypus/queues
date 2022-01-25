<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests;

use Queues\Api\V1\Presentation\Http\FormRequest;

class GetTokenRequest extends FormRequest
{
    public string $identity;

    public string $password;

    public string $deviceName;

    public function rules(): array
    {
        return [
            'identity' => 'required',
            'password' => 'required',
            'deviceName' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute is required',
        ];
    }
}
