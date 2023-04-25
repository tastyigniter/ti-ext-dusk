<?php

namespace Igniter\Dusk\Tests\Pages\Admin\Auth;

use Igniter\Dusk\Classes\AdminPage;
use Laravel\Dusk\Browser;

class ResetPassword extends AdminPage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin/login/reset';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertTitleContains('Reset Password -')
            ->assertPresent('@emailField')
            ->assertPresent('@submitButton')
            ->assertPresent('@backToLoginLink');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@emailField' => 'input[name="email"]',
            '@submitButton' => 'button[type="submit"]',
            '@backToLoginLink' => '.login-container a.btn',
        ];
    }
}
