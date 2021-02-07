<?php

namespace Igniter\Dusk\Tests\Pages\Admin;

use Igniter\Dusk\Classes\AdminPage;
use Laravel\Dusk\Browser;

class Dashboard extends AdminPage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/dashboard';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertTitleContains('Dashboard -')
            ->assertPresent('@mainMenu')
            ->assertPresent('@accountMenuLink')
            ->waitFor('.dashboard-widget')
            ->assertSee('Getting started')
            ->assertSee('TastyIgniter News');
    }
}
