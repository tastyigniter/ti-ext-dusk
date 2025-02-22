<?php

declare(strict_types=1);

namespace Igniter\Dusk;

use Igniter\Dusk\Commands\DuskCommand;
use Igniter\Dusk\Commands\DuskFailsCommand;
use Igniter\Dusk\Commands\MakeCommand;
use Igniter\Dusk\Commands\PageCommand;
use Igniter\Dusk\Commands\ComponentCommand;
use Laravel\Dusk\Console\ChromeDriverCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DuskServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot(): void
    {
        if (!$this->app->environment('production')) {
            Route::get('/_dusk/login/{userId}/{appContext?}', [
                'middleware' => 'web',
                'uses' => 'Igniter\Dusk\Controllers\UserController@login',
            ]);

            Route::get('/_dusk/logout/{appContext?}', [
                'middleware' => 'web',
                'uses' => 'Igniter\Dusk\Controllers\UserController@logout',
            ]);

            Route::get('/_dusk/user/{appContext?}', [
                'middleware' => 'web',
                'uses' => 'Igniter\Dusk\Controllers\UserController@user',
            ]);
        }
    }

    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DuskCommand::class,
                DuskFailsCommand::class,
                MakeCommand::class,
                PageCommand::class,
                ComponentCommand::class,
                ChromeDriverCommand::class,
            ]);
        }
    }
}
