# Deutsche Post Direkt DATAFACTORY Autocomplete 2.0 API Authentication SDK

The Autocomplete API makes address input easy for you and your customers with the automatic completion of postal data.

This SDK can only be used to generate API tokens for DATAFACTORY Autocomplete.
and does not offer any autocompletion functionality.
It is designed to be used together with a separate frontend library or SDK to offer Autocompletion functionality,
for example `@postdirekt/autocomplete-sdk` or `@postdirekt/autocomplete-library` on [npm](https://www.npmjs.com).

## Requirements

### System Requirements

- PHP 7.1+ with JSON extension

### Package Requirements

- `php-http/discovery`: Discovery service for HTTP client and message factory implementations
- `php-http/httplug`: Pluggable HTTP client abstraction
- `php-http/logger-plugin`: HTTP client logger plugin for HTTPlug
- `php-http/message`: Message factory implementations & message formatter for logging
- `php-http/message-factory`: HTTP message factory interfaces
- `psr/http-message`: PSR-7 HTTP message interfaces
- `psr/log`: PSR-3 logger interfaces

### Virtual Package Requirements

- `psr/http-client-implementation`: Any package that provides a PSR-18 compatible HTTP client
- `psr/http-factory-implementation`: Any package that provides PSR-7 compatible HTTP message factories
- `psr/http-message-implementation`: Any package that provides PSR-7 HTTP messages
- `psr/log-implementation`: Any package that provides a PSR-3 logger

### Development Package Requirements

- `guzzlehttp/psr7`: PSR-7 HTTP message implementation
- `phpunit/phpunit`: Testing framework
- `php-http/mock-client`: HTTPlug mock client implementation
- `phpstan/phpstan`: Static analysis tool
- `squizlabs/php_codesniffer`: Static analysis tool

## Installation

```bash
$ composer require postdirekt/sdk-api-autocomplete-authentication
```

## Uninstallation

```bash
$ composer remove postdirekt/sdk-api-autocomplete-authentication
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
