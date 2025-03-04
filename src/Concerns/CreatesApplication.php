<?php

declare(strict_types=1);

namespace Igniter\Dusk\Concerns;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Determines if a test SQLite database is being used
     *
     * @var bool
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
     * @return Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app['cache']->setDefaultDriver('array');
        $app->setLocale('en');

        $app['config']->set('mail.driver', 'array');

        return $app;
    }
}
