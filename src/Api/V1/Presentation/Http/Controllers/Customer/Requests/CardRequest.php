<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Customer\Requests;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Presentation\Http\FormRequest;

class CardRequest extends FormRequest
{
    public GenericIdInterface $cardId;

    public function rules(): array
    {
        return [
            'cardId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'cardId.required' => 'cardId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->cardId = GuidBasedImmutableId::of($this->input('cardId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cardId' => $this->route('cardId'),
        ]);
    }
}
