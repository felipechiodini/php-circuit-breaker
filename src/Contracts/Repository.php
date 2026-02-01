<?php

namespace FelipeChiodini\CircuitBreaker\Contracts;

interface Repository
{
    /**
     * @param string $key
     * @return int
     */
    public function tries(string $key): int;

    /**
     * @param string $key
     * @return void
     */
    public function incrementTry(string $key): void;

    /**
     * @param string $key
     * @return void
     */
    public function reset(string $key): void;

    /**
     * @param string $key
     * @return int
     */
    public function timeout(string $key): int;
}