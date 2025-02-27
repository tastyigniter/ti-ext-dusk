<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests\Pages\Admin\Settings;

use Override;
use Igniter\Dusk\Classes\AdminPage;
use Laravel\Dusk\Browser;

class MailSettings extends AdminPage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    #[Override]
    public function url()
    {
        return '/admin/settings/edit/general';
    }

    /**
     * Assert that the browser is on the page.
     */
    #[Override]
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
            ->assertTitleContains('Settings: General -')
            ->assertPresent('@mainMenu')
            ->assertPresent('@accountMenuLink')
            ->assertSee('Settings General');
    }

    #[Override]
    public function elements()
    {
        return [

        ];
    }
}
