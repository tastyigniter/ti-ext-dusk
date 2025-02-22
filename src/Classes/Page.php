<?php

declare(strict_types=1);

namespace Igniter\Dusk\Classes;

abstract class Page extends \Laravel\Dusk\Page
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [];
    }
}
