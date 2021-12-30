<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Presentation\Http\FormRequest;

class DismissAchievementRequest extends FormRequest
{
    public GenericIdInterface $workspaceId;

    public GenericIdInterface $cardId;

    public GenericIdInterface $achievementId;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'cardId' => 'required',
            'achievementId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'cardId.required' => 'cardId required',
            'achievementId.required' => 'achievementId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->cardId = GuidBasedImmutableId::of($this->input('cardId'));
        $this->achievementId = GuidBasedImmutableId::of($this->input('achievementId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'cardId' => $this->route('cardId'),
        ]);
    }
}
