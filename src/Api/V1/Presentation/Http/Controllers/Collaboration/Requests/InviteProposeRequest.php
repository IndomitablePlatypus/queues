<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

class InviteProposeRequest extends FormRequest
{
    public GuidBasedImmutableId $workspaceId;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
        ]);
    }

}
