<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Collaboration\Requests;

use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
{
    public GuidBasedImmutableId $inviteId;

    public function rules(): array
    {
        return [
            'inviteId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'inviteId.required' => 'inviteId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->inviteId = GuidBasedImmutableId::of($this->input('inviteId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'inviteId' => $this->route('inviteId'),
        ]);
    }

}
