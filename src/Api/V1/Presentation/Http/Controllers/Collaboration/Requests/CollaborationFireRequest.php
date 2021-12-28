<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

class CollaborationFireRequest extends FormRequest
{
    public GuidBasedImmutableId $workspaceId;

    public GuidBasedImmutableId $collaboratorId;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'collaboratorId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'collaboratorId.required' => 'collaboratorId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->collaboratorId = GuidBasedImmutableId::of($this->input('collaboratorId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'collaboratorId' => $this->route('collaboratorId'),
        ]);
    }

}
