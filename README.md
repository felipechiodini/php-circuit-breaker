# Circuit Breaker

A PHP implementation of the Circuit Breaker pattern.

## Description

The Circuit Breaker pattern is a design pattern used in software development to detect failures and encapsulate the logic of preventing a failure from constantly recurring. This implementation provides a simple and flexible way to integrate circuit breaker functionality into your PHP applications.

## Installation

Install via Composer:

```bash
composer require felipechiodini/circuit-breaker
```

## Usage

```php
use FelipeChiodini\CircuitBreaker\CircuitBreaker;
use FelipeChiodini\CircuitBreaker\Contracts\Repository;
use FelipeChiodini\CircuitBreaker\Contracts\CircuitBreakConfig;

// Implement the Repository and CircuitBreakConfig interfaces
$repository = new YourRepositoryImplementation();
$config = new YourConfigImplementation();

$circuitBreaker = new CircuitBreaker($repository);

try {
    $result = $circuitBreaker->run(function() {
        // Your potentially failing operation
        return someApiCall();
    }, $config);
} catch (IsOpenException $e) {
    // Circuit is open, handle accordingly
} catch (\Throwable $th) {
    // Other exceptions
}
```

## Testing

Run the tests using PHPUnit:

```bash
./vendor/bin/phpunit tests
```

## License

This project is licensed under the MIT License - see the LICENSE file for details.