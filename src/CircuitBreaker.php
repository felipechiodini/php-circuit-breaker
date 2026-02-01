<?php

namespace FelipeChiodini\CircuitBreaker;

use FelipeChiodini\CircuitBreaker\Contracts\CircuitBreakConfig;
use FelipeChiodini\CircuitBreaker\Contracts\Repository;
use FelipeChiodini\CircuitBreaker\Exceptions\IsOpenException;

/**
 * @author Felipe Bona <felipechiodinibona@hotmail.com>
 * @package FelipeChiodini\CircuitBreaker
 * @version 1.0.0
 */
class CircuitBreaker
{
    /**
     * @var Repository
     */
    public function __construct(
        protected Repository $repository
    ) {
    }

    /**
     * run a request through the circuit breaker
     * 
     * @param callable $callback
     * @param CircuitBreakConfig $config
     * @return mixed
     * @throws IsOpenException
     */
    public function run(callable $request, CircuitBreakConfig $config): mixed
    {
        $key = $config->getKey();

        if ($this->repository->tries($key) >= $config->maxTries()) {
            if ($this->repository->timeout($key) < $config->retryAfter()) {
                throw new IsOpenException('Circuit breaker is open');
            }
        }

        try {
            $response = $request();
            $this->repository->reset($key);

            return $response;
        } catch (\Throwable $th) {
            $this->repository->incrementTry($key);

            throw $th;
        }
    }
}