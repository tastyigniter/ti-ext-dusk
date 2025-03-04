<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests\Browser\Admin;

use Igniter\Dusk\Classes\DuskTestCase;
use Igniter\Dusk\Tests\Pages\Admin\Settings\GeneralSettings;
use Igniter\Dusk\Tests\Pages\Admin\Settings\SetupSettings;
use Laravel\Dusk\Browser;

class SettingsTest extends DuskTestCase
{
    public function test_general_setting_form(): void
    {
        $this->browse(function(Browser $browser): void {
            $browser->login()
                ->visit(new GeneralSettings)
                ->click('@siteTab')
                ->select('@defaultCurrencyField', 1)
                ->click('@saveButton')
                ->waitForReload()
                ->waitFor('@flashMessage')
                ->assertSeeIn('@flashMessage', 'updated successfully');
        });
    }

    public function test_setup_setting_form(): void
    {
        $this->browse(function(Browser $browser): void {
            $browser->login()
                ->visit(new SetupSettings)
                ->click('@saveButton')
                ->waitForReload()
                ->waitFor('@flashMessage')
                ->assertSeeIn('@flashMessage', 'updated successfully');
        });
    }
}
