<?php

declare(strict_types=1);

namespace Igniter\Dusk\Classes;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Igniter\Dusk\Concerns\CreatesApplication;
use Igniter\Dusk\Concerns\RunsMigrations;
use Igniter\Dusk\Concerns\TestsExtensions;
use Igniter\User\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;
    use RunsMigrations;
    use TestsExtensions;
    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     */
    public static function prepare(): void
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Register the base URL with Dusk.
     */
    protected function setUp(): void
    {
        $this->resetManagers();

        parent::setUp();

        if ($this->usingTestDatabase) {
            $this->runIgniterUpCommand();
        }

        $this->detectExtension();

        Mail::pretend();

        $screenshotDir = Config::get('igniter.dusk::dusk.screenshotsPath', storage_path('dusk/screenshots'));
        $consoleDir = Config::get('igniter.dusk::dusk.consolePath', storage_path('dusk/console'));
        $sourceDir = Config::get('igniter.dusk::dusk.sourcePath', storage_path('dusk/source'));

        $this->ensureStoreDirectoriesExists();

        Browser::$baseUrl = $this->baseUrl();

        Browser::$storeScreenshotsAt = $screenshotDir;

        Browser::$storeConsoleLogAt = $consoleDir;

        Browser::$storeSourceAt = $sourceDir;

        Browser::$userResolver = function() {
            return $this->user();
        };

        $this->registerBrowserMacros();
    }

    protected function tearDown(): void
    {
        if ($this->usingTestDatabase && $this->testDatabasePath !== null) {
            unlink($this->testDatabasePath);
        }

        parent::tearDown();
    }

    /**
     * Return the default user to authenticate.
     *
     * @return User|int|null
     */
    protected function user()
    {
        return User::whereUsername(env('DUSK_ADMIN_USER', 'admin'))->first();
    }

    /**
     * Defines macros for use in browser tests
     *
     * @return void
     */
    protected function registerBrowserMacros()
    {
        Browser::macro('hasClass', function(string $selector, string $class): bool {
            $classes = preg_split('/\s+/', $this->attribute($selector, 'class'), -1, PREG_SPLIT_NO_EMPTY);

            if ($classes === [] || $classes === false) {
                return false;
            }

            return in_array($class, $classes);
        });
    }

    protected function ensureStoreDirectoriesExists(): void
    {
        $screenshotDir = Config::get('igniter.dusk::dusk.screenshotsPath', storage_path('dusk/screenshots'));
        $consoleDir = Config::get('igniter.dusk::dusk.consolePath', storage_path('dusk/console'));

        if (!is_dir($screenshotDir)) {
            mkdir($screenshotDir, 0777, true);
        }

        if (!is_dir($consoleDir)) {
            mkdir($consoleDir, 0777, true);
        }
    }
}
