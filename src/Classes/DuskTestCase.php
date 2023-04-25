<?php

namespace Igniter\Dusk\Classes;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Igniter\Admin\Models\User;
use Igniter\Dusk\Concerns\CreatesApplication;
use Igniter\Dusk\Concerns\RunsMigrations;
use Igniter\Dusk\Concerns\TestsExtensions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, RunsMigrations, TestsExtensions;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
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
    public function setUp(): void
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

        Browser::$userResolver = function () {
            return $this->user();
        };

        $this->registerBrowserMacros();
    }

    public function tearDown(): void
    {
        if ($this->usingTestDatabase && isset($this->testDatabasePath)) {
            unlink($this->testDatabasePath);
        }

        parent::tearDown();
    }

    /**
     * Return the default user to authenticate.
     *
     * @return \Igniter\Admin\Models\User|int|null
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
        Browser::macro('hasClass', function (string $selector, string $class) {
            $classes = preg_split('/\s+/', $this->attribute($selector, 'class'), -1, PREG_SPLIT_NO_EMPTY);

            if (empty($classes)) {
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
