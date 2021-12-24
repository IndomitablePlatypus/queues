<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use JetBrains\PhpStorm\ArrayShape;
use Queues\Api\V1\Presentation\Http\FormRequest;

final class ChangeWorkspaceProfileRequest extends FormRequest
{
    use ArrayPresenterTrait;

    public GenericIdInterface $collaboratorId;

    public GenericIdInterface $workspaceId;

    #[ArrayShape(['name' => 'string', 'description' => 'string', 'address' => 'string'])]
    public array $profile = [];

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'name.required' => 'name required',
            'description.required' => 'description required',
            'address.required' => 'address required',
        ];
    }

    public function passedValidation(): void
    {
        $this->collaboratorId = GuidBasedImmutableId::of($this->input('collaboratorId'));
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->profile['name'] = $this->input('name');
        $this->profile['description'] = $this->input('description');
        $this->profile['address'] = $this->input('address');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'collaboratorId' => $this->user()->id,
            'workspaceId' => $this->route('workspaceId'),
        ]);
    }

    public function toArray(): array
    {
        return ['profile' => $this->profile];
    }
}
