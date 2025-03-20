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
