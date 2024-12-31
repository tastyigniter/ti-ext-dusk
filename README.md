<p align="center">
    <a href="https://github.com/tastyigniter/ti-ext-dusk/actions"><img src="https://github.com/tastyigniter/ti-ext-dusk/actions/workflows/pipeline.yml/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/tastyigniter/ti-ext-dusk"><img src="https://img.shields.io/packagist/dt/tastyigniter/ti-ext-dusk" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/tastyigniter/ti-ext-dusk"><img src="https://img.shields.io/packagist/v/tastyigniter/ti-ext-dusk" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/tastyigniter/ti-ext-dusk"><img src="https://img.shields.io/packagist/l/tastyigniter/ti-ext-dusk" alt="License"></a>
</p>

## Introduction

The TastyIgniter Dusk extension brings [Laravel Dusk's](https://laravel.com/docs/dusk) browser testing capabilities to your TastyIgniter application. It equips core and extension developers with the tools to write and run automated browser tests, ensuring your application's functionality is robust and reliable.

> **Note:** This extension is intended for development purposes only. It should never be installed in a production environment, as it could allow arbitrary users to authenticate with your application.

## Features

- **Automated Browser Testing:** Write and run tests that simulate user interactions with your application.
- **Easy Setup:** Get started with browser testing quickly with minimal configuration.

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-dusk:"^4.0" -W
```

After installing the extension, run the following command to create a `tests/Browser` directory, an example Dusk test, and install the Chrome Driver binary for your operating system:

```bash
php artisan dusk:install
```

## Getting started

Set the `APP_URL` environment variable in your application's `.env` file to the URL of your TastyIgniter application. This URL is used when running your browser tests.

## Usage

### Writing tests

You can write your browser tests in the `tests/Browser` directory of your extension. By default, the extension creates an example test in the `tests/Browser/ExampleTest.php` file. If you are new to writing Dusk tests, you can refer to the [Laravel Dusk documentation](https://laravel.com/docs/dusk) for more information.

### Running tests

To run your browser tests, use the `dusk` command to run all the tests in the `tests/Browser` directory.

```bash
php artisan dusk
```

You can also run a specific test file by passing the path to the test file as an argument to the `dusk` command:

```bash
php artisan dusk tests/Browser/ExampleTest.php
```

You can re-run tests that failed in the previous test run the following command:

```bash
php artisan dusk:fails
```

### Managing Chrome Driver

The `dusk:chrome-driver` command allows you to install a different version of the Chrome Driver binary.

```bash
# Install the latest version of ChromeDriver for your OS...
php artisan dusk:chrome-driver
 
# Install a given version of ChromeDriver for your OS...
php artisan dusk:chrome-driver 86
 
# Install a given version of ChromeDriver for all supported OSs...
php artisan dusk:chrome-driver --all
 
# Install the version of ChromeDriver that matches the detected version of Chrome / Chromium for your OS...
php artisan dusk:chrome-driver --detect
```

## Changelog

Please see [CHANGELOG](https://github.com/tastyigniter/ti-ext-dusk/blob/master/CHANGELOG.md) for more information on what has changed recently.

## Reporting issues

If you encounter a bug in this extension, please report it using the [Issue Tracker](https://github.com/tastyigniter/ti-ext-dusk/issues) on GitHub.

## Contributing

Contributions are welcome! Please read [TastyIgniter's contributing guide](https://tastyigniter.com/docs/contribution-guide).

## Security vulnerabilities

For reporting security vulnerabilities, please see our [our security policy](https://github.com/tastyigniter/ti-ext-dusk/security/policy).

## License

TastyIgniter Coupons extension is open-source software licensed under the [MIT license](https://github.com/tastyigniter/ti-ext-dusk/blob/master/LICENSE.md).
