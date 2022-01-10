<?php

namespace App\OpenApi\Requests\Customer;

use App\OpenApi\Schemas\RequirementProfileRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ChangeRequirementDescriptionRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('ChangeRequirementDescription')
            ->description('Change requirement description request')
            ->content(
                MediaType::json()->schema(RequirementProfileRequestSchema::ref())
            );
    }

}
