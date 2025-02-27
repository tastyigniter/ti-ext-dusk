<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests\Pages\Admin\Auth;

use Igniter\Dusk\Classes\AdminPage;
use Laravel\Dusk\Browser;
use Override;

class ResetPassword extends AdminPage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    #[Override]
    public function url()
    {
        return '/admin/login/reset';
    }

    /**
     * Assert that the browser is on the page.
     */
    #[Override]
    public function assert(Browser $browser): void
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
    #[Override]
    public function elements()
    {
        return [
            '@emailField' => 'input[name="email"]',
            '@submitButton' => 'button[type="submit"]',
            '@backToLoginLink' => '.login-container a.btn',
        ];
    }
}
