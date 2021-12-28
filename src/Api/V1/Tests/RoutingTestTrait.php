<?php

namespace Queues\Api\V1\Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Testing\TestResponse;
use Queues\Api\V1\Config\Routing\Routing;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

trait RoutingTestTrait
{
    use MakesHttpRequests;

    protected string $token = '';

    public function getRoute(string $name, array $arguments = []): string
    {
        try {
            $path = explode(Routing::PREFIX_API, $name);
            return route(end($path), $arguments);
        } catch (RouteNotFoundException) {
            $this->fail("Route $name not found");
        }
    }

    protected function rGet(string $name, array $routeArgs = []): TestResponse
    {
        return $this->request('get', $name, $routeArgs);
    }

    protected function rPost(string $name, array $routeArgs = [], array $params = []): TestResponse
    {
        return $this->request('post', $name, $routeArgs, $params);
    }

    protected function rPut(string $name, array $routeArgs = [], array $params = []): TestResponse
    {
        return $this->request('put', $name, $routeArgs, $params);
    }

    protected function rDelete(string $name, array $routeArgs = [], array $params = []): TestResponse
    {
        return $this->request('delete', $name, $routeArgs, $params);
    }

    protected function request(string $method, string $name, array $routeArgs = [], array $params = []): TestResponse
    {
        if (!empty($this->token)) {
            $this->withToken($this->token);
        }
        return $this->$method($this->getRoute($name, $routeArgs), $params);
    }

    protected function tokenize(User $user): void
    {
        $token = $user->createToken($this->faker->word());
        $this->withToken($token->plainTextToken);
    }
}
