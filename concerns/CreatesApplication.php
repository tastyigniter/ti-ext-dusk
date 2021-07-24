<?php

namespace Igniter\Dusk\Concerns;

use Illuminate\Support\Facades\Config;

trait CreatesApplication
{
    /**
     * Determines if a test SQLite database is being used
     *
     * @var boolean
     */
    protected $usingTestDatabase = FALSE;

    /**
     * The test SQLite database in use
     *
     * @var string
     */
    protected $testDatabasePath;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $app['cache']->setDefaultDriver('array');
        $app->setLocale('en');

        $app['config']->set('mail.driver', 'array');

        $app->useExtensionsPath(realpath(base_path().Config::get('system.extensionsPath')));

        return $app;
    }
}
