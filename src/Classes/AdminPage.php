<?php

namespace Igniter\Dusk\Classes;

abstract class AdminPage extends \Laravel\Dusk\Page
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
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
