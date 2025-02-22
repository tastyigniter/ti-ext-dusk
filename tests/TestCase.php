<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests;

use Igniter\Dusk\Extension;
use Igniter\Flame\ServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            Extension::class,
        ];
    }
}
