<?php

namespace Igniter\Dusk\Concerns;

use Illuminate\Support\Facades\Artisan;

trait RunsMigrations
{
    protected function runIgniterUpCommand()
    {
        Artisan::call('igniter:up');
    }

    protected function runIgniterDownCommand()
    {
        Artisan::call('igniter:down --force');
    }
}
