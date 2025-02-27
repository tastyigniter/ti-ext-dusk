<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests\Pages\Admin\Auth;

use Override;
use Igniter\Dusk\Classes\AdminPage;
use Laravel\Dusk\Browser;

class Login extends AdminPage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    #[Override]
    public function url()
    {
        return '/admin/login';
    }

    /**
     * Assert that the browser is on the page.
     */
    #[Override]
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
            ->assertTitleContains('Login -')
            ->assertPresent('@usernameField')
            ->assertPresent('@passwordField')
            ->assertPresent('@submitButton')
            ->assertPresent('@resetPasswordLink');
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
            '@usernameField' => 'input[name="username"]',
            '@passwordField' => 'input[name="password"]',
            '@submitButton' => 'button[type="submit"]',
            '@resetPasswordLink' => '.login-container .reset-password > a',
        ];
    }

    public function fillInLoginForm(Browser $browser, $username, $password)
    {
        return $browser->type('@usernameField', $username)
            ->type('@passwordField', $password);
    }
}
