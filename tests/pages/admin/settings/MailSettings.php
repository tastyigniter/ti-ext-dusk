<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests\Pages\Admin\Settings;

use Igniter\Dusk\Classes\AdminPage;
use Laravel\Dusk\Browser;

class MailSettings extends AdminPage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/settings/edit/general';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
            ->assertTitleContains('Settings: General -')
            ->assertPresent('@mainMenu')
            ->assertPresent('@accountMenuLink')
            ->assertSee('Settings General');
    }

    public function elements()
    {
        return [

        ];
    }
}
