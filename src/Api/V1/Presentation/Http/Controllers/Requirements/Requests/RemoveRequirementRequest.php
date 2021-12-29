<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Requirements\Requests;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

final class RemoveRequirementRequest extends FormRequest
{
    public GuidBasedImmutableId $workspaceId;

    public GuidBasedImmutableId $planId;

    public GuidBasedImmutableId $requirementId;


    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'planId' => 'required',
            'requirementId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'planId.required' => 'planId required',
            'requirementId.required' => 'requirementId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
        $this->requirementId = GuidBasedImmutableId::of($this->input('requirementId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'planId' => $this->route('planId'),
            'requirementId' => $this->route('requirementId'),
        ]);
    }
}
