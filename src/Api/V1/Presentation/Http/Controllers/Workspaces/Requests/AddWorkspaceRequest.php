<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\ArrayPresenterTrait;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

final class AddWorkspaceRequest extends FormRequest
{
    use ArrayPresenterTrait;

    public GenericIdInterface $keeperId;

    public GenericIdInterface $workspaceId;

    #[ArrayShape(['name' => 'string', 'description' => 'string', 'address' => 'string'])]
    public array $profile = [];

    public function rules(): array
    {
        return [
            'keeperId' => 'required',
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'keeperId.required' => 'keeperId required',
            'name.required' => 'name required',
            'description.required' => 'description required',
            'address.required' => 'address required',
        ];
    }

    public function passedValidation(): void
    {
        $this->keeperId = GuidBasedImmutableId::of($this->input('keeperId'));
        $this->workspaceId = GuidBasedImmutableId::make();
        $this->profile['name'] = $this->input('name');
        $this->profile['description'] = $this->input('description');
        $this->profile['address'] = $this->input('address');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'keeperId' => $this->user()->id,
        ]);
    }

    public function toArray(): array
    {
        return $this->_toArray(true, true, true);
    }
}
