<?php

declare(strict_types=1);

namespace Igniter\Dusk;

use Igniter\System\Classes\BaseExtension;

/**
 * Dusk Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Register method, called when the extension is first registered.
     */
    public function register(): void
    {
        $this->app->register(DuskServiceProvider::class);
    }
}
