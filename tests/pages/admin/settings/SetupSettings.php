<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests\Pages\Admin\Settings;

use Igniter\Dusk\Classes\AdminPage;
use Laravel\Dusk\Browser;
use Override;

class SetupSettings extends AdminPage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    #[Override]
    public function url()
    {
        return '/admin/settings/edit/setup';
    }

    /**
     * Assert that the browser is on the page.
     */
    #[Override]
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
            ->assertTitleContains('Settings: Setup -')
            ->assertPresent('@mainMenu')
            ->assertPresent('@accountMenuLink');
    }

    #[Override]
    public function elements()
    {
        return [
            '@orderTab' => 'a[href="#primarytab-1"]',
            '@reservationTab' => 'a[href="#primarytab-2"]',
            '@invoicingTab' => 'a[href="#primarytab-3"]',
            '@taxationTab' => 'a[href="#primarytab-4"]',
        ];
    }
}
