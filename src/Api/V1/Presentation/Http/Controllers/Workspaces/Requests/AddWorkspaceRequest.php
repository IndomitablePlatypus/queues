<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests;

use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

final class AddWorkspaceRequest extends FormRequest
{
    use ArrayPresenterTrait;

    #[ArrayShape(['name' => 'string', 'description' => 'string', 'address' => 'string'])]
    public array $profile = [];

    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name required',
            'description.required' => 'description required',
            'address.required' => 'address required',
        ];
    }

    public function passedValidation(): void
    {
        $this->profile['name'] = $this->input('name');
        $this->profile['description'] = $this->input('description');
        $this->profile['address'] = $this->input('address');
    }

    public function toArray(): array
    {
        return $this->_toArray(true, true, true);
    }
}
