<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

final class ChangePlanDescriptionRequest extends FormRequest
{
    public GuidBasedImmutableId $workspaceId;

    public GuidBasedImmutableId $planId;

    public string $description;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'planId' => 'required',
            'description' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'planId.required' => 'planId required',
            'description.required' => 'description required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
        $this->description = $this->input('description');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'planId' => $this->route('planId'),
        ]);
    }
}
