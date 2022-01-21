<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

final class AddPlanRequest extends FormRequest
{
    public GuidBasedImmutableId $workspaceId;

    public string $name;

    public string $description;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'name' => 'required',
            'description' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'name.required' => 'name required',
            'description.required' => 'description required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->name = $this->input('name');
        $this->description = $this->input('description');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
        ]);
    }
}
