<?php

declare(strict_types=1);

namespace Igniter\Dusk\Classes;

use Laravel\Dusk\Page;
use Override;

abstract class AdminPage extends Page
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    #[Override]
    public static function siteElements()
    {
        return [
            '@sideNav' => '#side-nav-menu',

            '@mainMenu' => '#menu-mainmenu',
            '@accountMenuLink' => '#menuitem-account > a',

            '@flashMessage' => '#notification .alert',

            '@saveButton' => '#toolbar [data-request="onSave"]',
            '@saveAndCloseButton' => '#toolbar [data-request="onSave"][data-request-data="close:1"]',
        ];
    }
}
