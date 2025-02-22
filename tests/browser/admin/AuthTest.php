<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests\Browser\Admin;

use Igniter\Dusk\Classes\DuskTestCase;
use Igniter\Dusk\Tests\Components\Admin\SideNav;
use Igniter\Dusk\Tests\Pages\Admin\Auth\Login;
use Igniter\Dusk\Tests\Pages\Admin\Auth\ResetPassword;
use Igniter\Dusk\Tests\Pages\Admin\Dashboard;
use Laravel\Dusk\Browser;

class AuthTest extends DuskTestCase
{
    public function testLoginAndLogout(): void
    {
        $this->browse(function(Browser $browser): void {
            $username = $username ?? env('DUSK_ADMIN_USER', 'admin');
            $password = $password ?? env('DUSK_ADMIN_PASS', 'admin');

            $browser->visit(new Login)
                ->fillInLoginForm($username, $password)
                ->click('@submitButton')
                ->waitForReload();

            $browser->on(new Dashboard)
                ->click('@accountMenuLink')
                ->within(new SideNav, function(Browser $browser): void {
                    $browser->assertPresent('@navItem');
                })
                ->clickLink('Logout');

            $browser->on(new Login);
        });
    }

    public function testResetPassword(): void
    {
        $this->browse(function(Browser $browser): void {
            $browser->visit(new Login)
                ->click('@resetPasswordLink');

            $browser->on(new ResetPassword)
                ->type('@emailField', env('DUSK_ADMIN_EMAIL', 'admin@domain.tld'))
                ->click('@submitButton')
                ->waitFor('@flashMessage')
                ->assertSeeIn('@flashMessage', 'sent a password reset link to your email');
        });
    }
}
