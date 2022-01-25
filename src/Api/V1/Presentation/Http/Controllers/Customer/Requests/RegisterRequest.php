<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Support\Facades\Hash;
use Queues\Api\V1\Presentation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public GuidBasedImmutableId $id;

    public string $phone;

    public string $name;

    public string $password;

    public string $deviceName;

    public function rules(): array
    {
        return [
            'phone' => 'required',
            'name' => 'required',
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

    public function passedValidation()
    {
        parent::passedValidation();
        $this->id = GuidBasedImmutableId::make();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->phone,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ];
    }
}
