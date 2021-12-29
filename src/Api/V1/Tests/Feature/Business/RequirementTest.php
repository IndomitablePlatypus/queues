<?php

namespace Feature\Business;

use App\Jobs\EstablishRelation;
use App\Models\Plan;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
use Queues\Api\V1\Config\Routing\Routing;
use Queues\Api\V1\Domain\RelationType;
use Queues\Api\V1\Tests\RoutingTestTrait;
use Queues\Api\V1\Tests\TestApplicationTrait;
use Queues\Tests\BaseTestCase;

class RequirementTest extends BaseTestCase
{
    use TestApplicationTrait, RoutingTestTrait;

}
