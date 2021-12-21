<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Support\Facades\Hash;
use Queues\Api\V1\Presentation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public GuidBasedImmutableId $id ;

    public string $username;

    public string $password;

    public string $name;

    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
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
        $array = parent::toArray();
        $array['password'] = Hash::make($this->password);
        return $array;
    }
}
