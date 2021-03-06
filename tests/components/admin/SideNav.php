<?php

namespace Igniter\Dusk\Tests\Components\Admin;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class SideNav extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '@sideNav';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@navItem' => 'li.nav-item',
            '@activeNavItem' => 'li.nav-item.active',
            '@childNavItem' => 'li.nav-item .nav > li.nav-item',
        ];
    }
}
