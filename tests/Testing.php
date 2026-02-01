<?php

namespace Tests;

use FelipeChiodini\CircuitBreaker\CircuitBreaker;
use FelipeChiodini\CircuitBreaker\Contracts\CircutBreakConfig;
use FelipeChiodini\CircuitBreaker\Contracts\Repository;
use PHPUnit\Framework\TestCase;

class Testing extends TestCase
{
    public function test_closed()
    {
        $repo = $this->createMock(Repository::class);
        $config = $this->createMock(CircutBreakConfig::class);

        $config->method('getKey')
            ->willReturn('test');

        $repo->method('tries')
            ->willReturn(0);

        $repo->method('reset')
            ->willReturn(null);

        $breaker = new CircuitBreaker($repo);

        $request = function () {
            return 'hello';
        };

        $breaker->run($request, $config);
    }
}