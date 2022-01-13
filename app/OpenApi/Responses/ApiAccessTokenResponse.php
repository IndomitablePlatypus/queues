<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ApiAccessTokenResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(
                Schema::string()
                    ->nullable(false)
                    ->description('API Access Bearer Token')
                    ->example('9|eigK2WNOHtJEOKtgcXD6m2NIaDFVcIMDfCMrsKii')
            ))
            ->description('Access token');
    }
}
