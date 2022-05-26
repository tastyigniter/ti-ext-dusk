<?php

namespace Igniter\Dusk\Concerns;

trait CreatesApplication
{
    /**
     * Determines if a test SQLite database is being used
     *
     * @var boolean
     */
    protected $usingTestDatabase = false;

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

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $app['cache']->setDefaultDriver('array');
        $app->setLocale('en');

        $app['config']->set('mail.driver', 'array');

        return $app;
    }
}
