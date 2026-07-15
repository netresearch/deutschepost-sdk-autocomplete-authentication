# Deutsche Post Direkt DATAFACTORY Autocomplete 2.0 API Authentication SDK

## Deprecation Notice

In agreement with Deutsche Post Direkt GmbH, the **ADDRESSFACTORY** and **AUTOCOMPLETE** modules have been discontinued and are entering end-of-life.

* No new customers will be onboarded for these modules by Deutsche Post Direkt.
* Existing customers may continue to access the GitHub source code until approximately **June 2027**.
* Official support for existing users will end on **December 31, 2026**.

The Autocomplete API makes address input easy for you and your customers with
the automatic completion of postal data.

This SDK can be used to generate API tokens for DATAFACTORY Autocomplete
web service access. It does not connect to autocompletion endpoints.
Instead, the generated token can be used together with a separate frontend
library or SDK, for example [@netresearch/postdirekt-autocomplete-sdk](https://www.npmjs.com/package/@netresearch/postdirekt-autocomplete-sdk) or
[@netresearch/postdirekt-autocomplete-library](https://www.npmjs.com/package/@netresearch/postdirekt-autocomplete-library).

## Requirements

### System Requirements

- 8.1+ with JSON extension

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
- `rector/rector`: Refactoring tool
- `fig/log-test`: Test utilities for `psr/log`
- `squizlabs/php_codesniffer`: Static analysis tool

## Installation

```bash
composer require deutschepost/sdk-api-autocomplete-authentication
```

## Uninstallation

```bash
composer remove deutschepost/sdk-api-autocomplete-authentication
```

## Testing

```bash
composer run test
```

## Static code analysis

```bash
composer run phpstan
```

```bash
composer run lint
```

## Features

The Deutsche Post Direkt DATAFACTORY Autocomplete API Authentication SDK supports the following features:

- Create authentication token

### Authentication

#### Public API

The library's components suitable for consumption are

- service:
  - service factory
  - authentication service
- data transfer objects:
  - authentication token

#### Usage

```php
<?php
$logger = new \Psr\Log\NullLogger();
$serviceFactory = new \PostDirekt\Sdk\Autocomplete\Authentication\Service\ServiceFactory();
$authService = $serviceFactory->createAuthenticationService('username', 'password', $logger);

$token = $authService->authenticate();
```
