<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Presentation\Http\FormRequest;

class IssueCardRequest extends FormRequest
{
    public GenericIdInterface $workspaceId;

    public GenericIdInterface $planId;

    public GenericIdInterface $customerId;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'planId' => 'required',
            'customerId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'planId.required' => 'planId required',
            'customerId.required' => 'customerId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
        $this->customerId = GuidBasedImmutableId::of($this->input('customerId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
        ]);
    }
}
