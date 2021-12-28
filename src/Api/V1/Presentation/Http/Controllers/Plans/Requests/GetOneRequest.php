<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Presentation\Http\FormRequest;

class GetOneRequest extends FormRequest
{
    public GenericIdInterface $workspaceId;

    public GenericIdInterface $planId;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'planId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'planId.required' => 'planId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'planId' => $this->route('planId'),
        ]);
    }
}
