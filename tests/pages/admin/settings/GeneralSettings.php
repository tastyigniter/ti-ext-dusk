<?php

declare(strict_types=1);

namespace Igniter\Dusk\Tests\Pages\Admin\Settings;

use Override;
use Igniter\Dusk\Classes\AdminPage;
use Laravel\Dusk\Browser;

class GeneralSettings extends AdminPage
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
            ->assertPresent('@restaurantTab')
            ->assertSeeIn('@restaurantTab', 'Restaurant')
            ->assertPresent('@siteTab')
            ->assertSeeIn('@siteTab', 'Site');
    }

    #[Override]
    public function elements()
    {
        return [
            '@restaurantTab' => 'a[href="#primarytab-1"]',
            '@siteTab' => 'a[href="#primarytab-2"]',

            '@siteNameField' => 'input[name="Setting[site_name]"]',
            '@siteEmailField' => 'input[name="Setting[site_email]"]',
            '@siteUrlField' => 'input[name="Setting[site_url]"]',
            '@countryIdField' => 'input[name="Setting[country_id]"]',
            '@siteLogoField' => 'input[name="Setting[site_logo]"]',
            '@mapsField' => 'input[name="Setting[maps]"]',
            '@distanceUnitField' => 'input[name="Setting[distance_unit]"]',
            '@defaultGeocoderField' => 'input[name="Setting[default_geocoder]"]',
            '@mapsApiKeyField' => 'input[name="Setting[maps_api_key]"]',

            '@languageField' => 'input[name="Setting[language]"]',
            '@defaultLanguageField' => 'select[name="Setting[default_language]"]',
            '@detectLanguageField' => 'input[name="Setting[detect_language]"]',
            '@defaultCurrencyField' => 'select[name="Setting[default_currency_code]"]',
            '@currencyConverterApiField' => 'input[name="Setting[currency_converter[api]]"]',
            '@currencyConverterOerApiKeyField' => 'input[name="Setting[currency_converter[oer][apiKey]]"]',
            '@currencyConverterFixerioApiKeyField' => 'input[name="Setting[currency_converter[fixerio][apiKey]]"]',
            '@currencyConverterRefreshIntervalField' => 'input[name="Setting[currency_converter[refreshInterval]]"]',
            '@timezoneField' => 'input[name="Setting[date]"]',
        ];
    }
}
