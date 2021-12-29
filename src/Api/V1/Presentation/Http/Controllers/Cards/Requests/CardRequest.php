<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Presentation\Http\FormRequest;

class CardRequest extends FormRequest
{
    public GenericIdInterface $workspaceId;

    public GenericIdInterface $cardId;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'cardId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'cardId.required' => 'cardId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->cardId = GuidBasedImmutableId::of($this->input('cardId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'cardId' => $this->route('cardId'),
        ]);
    }
}
