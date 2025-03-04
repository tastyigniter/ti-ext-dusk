<?php

declare(strict_types=1);

namespace Igniter\Dusk\Classes;

use Override;

abstract class Page extends \Laravel\Dusk\Page
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    #[Override]
    public static function siteElements()
    {
        return [];
    }
}
