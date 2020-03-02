# Deutsche Post Direkt DATAFACTORY Autocomplete 2.0 API Authentication SDK

The Autocomplete API makes address input easy for you and your customers with the automatic completion of postal data.

This SDK can be used to generate an API token. It does not offer Autocompletion functionality itself.
It is designed to be used in conjunction with a JavaScript SDK to offer Autocompletion functionality.

## Requirements

### System Requirements

- PHP 7.1+ with JSON extension

### Package Requirements

- `netresearch/jsonmapper`: Mapper for unserializing JSON response messages into PHP objects
- `php-http/discovery`: Discovery service for HTTP client and message factory implementations
- `php-http/httplug`: Pluggable HTTP client abstraction
- `php-http/logger-plugin`: HTTP client logger plugin for HTTPlug
- `php-http/message`: Message factory implementations & message formatter for logging
- `php-http/message-factory`: HTTP message factory interfaces
- `psr/http-message`: PSR-7 HTTP message interfaces
- `psr/log`: PSR-3 logger interfaces

### Virtual Package Requirements

- `php-http/client-implementation`: Any package that provides a HTTPlug HTTP client
- `php-http/message-factory-implementationn`: Any package that provides HTTP message factories
- `psr/http-message-implementation`: Any package that provides PSR-7 HTTP messages

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
$authService = $serviceFactory->createAuthenticationService($logger);

$token = $authService->authenticate('username', 'password');
```
