<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Plans\Requests;

use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

final class LaunchPlanRequest extends FormRequest
{
    public GuidBasedImmutableId $workspaceId;

    public GuidBasedImmutableId $planId;

    public string $expirationDate;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'planId' => 'required',
            'expirationDate' => 'required|date|after:tomorrow',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'planId.required' => 'planId required',
            'expirationDate.required' => 'expirationDate required',
            'expirationDate.date' => 'expirationDate should be a date',
            'expirationDate.after' => 'expirationDate should be a date after tomorrow',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
        $this->expirationDate = $this->input('expirationDate');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'planId' => $this->route('planId'),
        ]);
    }
}
