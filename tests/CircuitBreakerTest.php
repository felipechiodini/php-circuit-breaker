<?php

namespace Tests;

use FelipeChiodini\CircuitBreaker\CircuitBreaker;
use FelipeChiodini\CircuitBreaker\Contracts\CircutBreakConfig;
use FelipeChiodini\CircuitBreaker\Contracts\Repository;
use FelipeChiodini\CircuitBreaker\Exceptions\IsOpenException;
use PHPUnit\Framework\TestCase;

class CircuitBreakerTest extends TestCase
{
    public function test_closed(): void
    {
        $repo = $this->createMock(Repository::class);
        $config = $this->createMock(CircutBreakConfig::class);

        $config->method('getKey')
            ->willReturn('test');

        $repo->method('tries')
            ->willReturn(0);

        $repo->method('reset');

        $breaker = new CircuitBreaker($repo);

        $request = function () {
            return 'hello';
        };

        $response = $breaker->run($request, $config);

        $this->assertEquals('hello', $response);
    }

    public function test_open(): void
    {
        $repo = $this->createMock(Repository::class);
        $config = $this->createMock(CircutBreakConfig::class);

        $config->method('getKey')
            ->willReturn('test');

        $repo->method('tries')
            ->willReturn(1);

        $config->method('maxTries')
            ->willReturn(1);

        $repo->method('timeout')
            ->willReturn(10);

        $config->method('retryAfter')
            ->willReturn(60);

        $breaker = new CircuitBreaker($repo);

        $request = function () {
            return 'hello';
        };
        
        $this->expectException(IsOpenException::class);

        $breaker->run($request, $config);
    }
}