<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ClearTokensResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(
                Schema::string()->format(Schema::FORMAT_UUID)->description('Customer Id')
            ))
            ->description('All tokens successfully cleared');
    }
}
