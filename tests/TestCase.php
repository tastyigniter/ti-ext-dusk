<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests;

use Igniter\Flame\ServiceProvider;
use Igniter\Dusk\Extension;

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
