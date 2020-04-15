# Deutsche Post Direkt DATAFACTORY Autocomplete 2.0 API Authentication SDK

The Autocomplete API makes address input easy for you and your customers with
the automatic completion of postal data.

This SDK can be used to generate API tokens for DATAFACTORY Autocomplete
web service access. It does not connect to autocompletion endpoints.
Instead, the generated token can be used together with a separate frontend
library or SDK, for example [@netresearch/postdirekt-autocomplete-sdk](https://www.npmjs.com/package/@netresearch/postdirekt-autocomplete-sdk) or
[@netresearch/postdirekt-autocomplete-library](https://www.npmjs.com/package/@netresearch/postdirekt-autocomplete-library).

## Requirements

### System Requirements

- PHP 7.1+ with JSON extension

### Package Requirements

- `php-http/discovery`: Discovery service for HTTP client and message factory implementations
- `php-http/httplug`: Pluggable HTTP client abstraction
- `php-http/logger-plugin`: HTTP client logger plugin for HTTPlug
- `psr/http-client`: PSR-18 HTTP client interfaces
- `psr/http-factory`: PSR-7 HTTP message factory interfaces
- `psr/http-message`: PSR-7 HTTP message interfaces
- `psr/log`: PSR-3 logger interfaces

### Virtual Package Requirements

- `psr/http-client-implementation`: Any package that provides a PSR-18 compatible HTTP client
- `psr/http-factory-implementation`: Any package that provides PSR-7 compatible HTTP message factories
- `psr/http-message-implementation`: Any package that provides PSR-7 HTTP messages

### Development Package Requirements

- `nyholm/psr7`: PSR-7 HTTP message factory & message implementation
- `phpunit/phpunit`: Testing framework
- `php-http/mock-client`: HTTPlug mock client implementation
- `phpstan/phpstan`: Static analysis tool
- `squizlabs/php_codesniffer`: Static analysis tool

## Installation

```bash
$ composer require deutschepost/sdk-api-autocomplete-authentication
```

## Uninstallation

```bash
$ composer remove deutschepost/sdk-api-autocomplete-authentication
```

## Testing

```bash
$ ./vendor/bin/phpunit -c test/phpunit.xml
```

## Static code analysis

```bash
$ ./vendor/bin/phpstan --level=7 analyze ./src/
```

```bash
$ ./vendor/bin/phpcs --standard=PSR12 src/ test/
```

## Features

The Deutsche Post Direkt DATAFACTORY Autocomplete API Authentication SDK supports the following features:

* Create authentication token

### Authentication

#### Public API

The library's components suitable for consumption are

* service:
  * service factory
  * authentication service
* data transfer objects:
  * authentication token

#### Usage

```php
<?php
$logger = new \Psr\Log\NullLogger();
$serviceFactory = new \PostDirekt\Sdk\Autocomplete\Authentication\Service\ServiceFactory();
$authService = $serviceFactory->createAuthenticationService('username', 'password', $logger);

$token = $authService->authenticate();
```
