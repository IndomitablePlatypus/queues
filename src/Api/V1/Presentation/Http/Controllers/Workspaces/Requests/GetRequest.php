<?php

namespace Queues\Api\V1\Presentation\Http\Controllers\Workspaces\Requests;

use App\Models\User;
use Queues\Api\V1\Presentation\Http\FormRequest;

class GetRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }
}
