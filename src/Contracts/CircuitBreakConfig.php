<?php

namespace FelipeChiodini\CircuitBreaker\Contracts;

interface CircuitBreakConfig
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return int
     */
    public function maxTries(): int;

    /**
     * retry after in seconds
     * 
     * @return int
     */
    public function retryAfter(): int;
}