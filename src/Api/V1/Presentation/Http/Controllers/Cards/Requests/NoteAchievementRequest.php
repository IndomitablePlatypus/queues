<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Cards\Requests;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Queues\Api\V1\Presentation\Http\FormRequest;

class NoteAchievementRequest extends FormRequest
{
    public GenericIdInterface $workspaceId;

    public GenericIdInterface $cardId;

    public GenericIdInterface $achievementId;

    public string $description;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'cardId' => 'required',
            'achievementId' => 'required',
            'description' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'cardId.required' => 'cardId required',
            'achievementId.required' => 'achievementId required',
            'description.required' => 'description required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->cardId = GuidBasedImmutableId::of($this->input('cardId'));
        $this->achievementId = GuidBasedImmutableId::of($this->input('achievementId'));
        $this->description = $this->input('description');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'cardId' => $this->route('cardId'),
        ]);
    }
}
