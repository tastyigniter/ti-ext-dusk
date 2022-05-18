<?php

namespace Igniter\Dusk;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk;

class DuskServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
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

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\DuskCommand::class,
                Commands\DuskFailsCommand::class,
                Commands\MakeCommand::class,
                Commands\PageCommand::class,
                Commands\ComponentCommand::class,
                Dusk\Console\ChromeDriverCommand::class,
            ]);
        }
    }
}
