<?php

declare(strict_types=1);

namespace Igniter\Dusk;

use Igniter\System\Classes\BaseExtension;
use Override;

/**
 * Dusk Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Register method, called when the extension is first registered.
     */
    #[Override]
    public function register(): void
    {
        $this->app->register(DuskServiceProvider::class);
    }
}
