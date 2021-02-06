Laravel Dusk browser testing for TastyIgniter
=
Integrates Laravel Dusk browser testing into your TastyIgniter application, providing core and extension developers with
the tools to run automated tests

> This extension is intended to be used for development purposes only,
> you should never install it in your production environment,
> as doing so could lead to arbitrary users being able to authenticate with your application.

## Setup

> You should ensure that your queue connection is set to `redis` in your queue configuration file.

1. Install this extension with its composer dependencies
4. Run `php artisan dusk:chrome-driver`
5. To start the browser test, run `php artisan dusk`

More information on writing Dusk tests [check the laravel docs.](https://laravel.com/docs/dusk)
