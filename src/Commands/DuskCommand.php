<?php

namespace Igniter\Dusk\Commands;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\System\Classes\ExtensionManager;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Exception\ProcessSignaledException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

class DuskCommand extends \Laravel\Dusk\Console\DuskCommand
{
    /**
     * @var string The name and signature of the console command.
     */
    protected $signature = 'dusk {extension?} {--without-tty : Disable output to TTY}';

    /**
     * @var string The console command description.
     */
    protected $description = 'Run the Dusk tests for the entire application, or for a single TastyIgniter extension.';

    /**
     * Indicates if the project has its own configuration files.
     *
     * @var bool
     */
    protected $hasConfigurationFiles;

    /**
     * @var array Extensions, and the path to their browser tests.
     */
    protected $extensions = [];

    public function handle()
    {
        $this->listExtensions();

        $this->purgeScreenshots();

        $this->purgeConsoleLogs();

        $options = $this->stripPhpArguments($_SERVER['argv']);

        return $this->withDuskEnvironment(function () use ($options) {
            $process = (new Process(array_merge(
                $this->binary(), $this->phpunitArguments($options)
            )))->setTimeout(null);

            try {
                $process->setTty(!$this->option('without-tty'));
            }
            catch (RuntimeException $e) {
                $this->output->writeln('Warning: '.$e->getMessage());
            }

            try {
                return $process->run(function ($type, $line) {
                    $this->output->write($line);
                });
            }
            catch (ProcessSignaledException $e) {
                if (extension_loaded('pcntl') && $e->getSignal() !== SIGINT) {
                    throw $e;
                }
            }
        });
    }

    protected function listExtensions()
    {
        $extensionManager = ExtensionManager::instance();

        if ($extensionCode = $this->argument('extension')) {
            if (!$extensionManager->hasExtension($extensionCode))
                throw new ApplicationException('Extension "'.$extensionCode.'" is not installed.');

            $this->extensions[$extensionCode] = str_after($extensionManager->path($extensionCode), base_path());
        }
        else {
            foreach ($extensionManager->getExtensions() as $extensionCode => $extension) {
                $this->extensions[$extensionCode] = str_after($extensionManager->path($extensionCode), base_path());
            }
        }
    }

    /**
     * Purge the failure screenshots.
     *
     * @return void
     */
    protected function purgeScreenshots()
    {
        $path = Config::get('igniter.dusk::dusk.screenshotsPath', base_path('tests/browser/screenshots'));
        if (!is_dir($path))
            return;

        $files = Finder::create()->files()
            ->in($path)
            ->name('failure-*');

        foreach ($files as $file) {
            @unlink($file->getRealPath());
        }
    }

    /**
     * Purge the console logs.
     *
     * @return void
     */
    protected function purgeConsoleLogs()
    {
        $path = Config::get('igniter.dusk::dusk.consolePath', base_path('tests/browser/console'));
        if (!is_dir($path))
            return;

        $files = Finder::create()->files()
            ->in($path)
            ->name('*.log');

        foreach ($files as $file) {
            @unlink($file->getRealPath());
        }
    }

    protected function stripPhpArguments($arguments)
    {
        $arguments = array_slice($arguments, 2);

        if ($this->argument('extension'))
            array_shift($arguments);

        if ($this->option('without-tty'))
            array_shift($arguments);

        return $arguments;
    }

    protected function setupDuskEnvironment()
    {
        if (file_exists(base_path($this->duskFile()))) {
            if (!file_exists(base_path('.env')))
                copy(base_path($this->duskFile()), base_path('.env'));

            if (file_get_contents(base_path('.env')) !== file_get_contents(base_path($this->duskFile())))
                $this->backupEnvironment();

            $this->writeConfigurationFiles();

            $this->refreshEnvironment();
        }

        $this->writeConfiguration();

        $this->setupSignalHandler();
    }

    protected function teardownDuskEnviroment()
    {
        $this->removeConfiguration();

        $this->removeConfigurationFiles();

        if (file_exists(base_path($this->duskFile())) && file_exists(base_path('.env.backup'))) {
            $this->restoreEnvironment();
        }
    }

    protected function writeConfigurationFiles()
    {
        if (!is_dir(base_path('config/dusk'))) {
            mkdir(base_path('config/dusk'), 0755, true);

            foreach (glob(extension_path('igniter/dusk/stubs/config/*.php')) as $file) {
                $path = pathinfo($file);
                copy($file, base_path('config/dusk/'.$path['basename']));
            }

            return;
        }

        $this->hasConfigurationFiles = true;
    }

    protected function writeConfiguration()
    {
        if (!file_exists($file = base_path('phpunit.dusk.xml')) &&
            !file_exists(base_path('phpunit.dusk.xml.dist'))) {
            $this->buildPhpUnitXmlStub($file);

            return;
        }

        $this->hasPhpUnitConfiguration = true;
    }

    protected function buildPhpUnitXmlStub($file)
    {
        copy($this->duskPhpUnitXmlFile(), $file);

        $testSuites = [];
        foreach ($this->extensions as $extensionCode => $extensionPath) {
            $testSuites[] = '<testsuite name="'.$extensionCode.' Browser Test Suite">'
                ."\n".'<directory suffix="Test.php">.'.$extensionPath.'tests/browser</directory>'
                ."\n".'</testsuite>';
        }

        $contents = file_get_contents($file);

        $contents = str_replace('{{test_suites}}', implode("\n", $testSuites), $contents);

        file_put_contents($file, $contents);
    }

    protected function removeConfigurationFiles()
    {
        if (!$this->hasConfigurationFiles OR !is_dir(base_path('config/dusk')))
            return;

        foreach (glob(base_path('config/dusk/*.php')) as $file)
            unlink($file);

        rmdir(base_path('config/dusk'));
    }

    protected function duskFile()
    {
        if (file_exists(base_path($file = '.env.dusk.'.$this->laravel->environment())))
            return $file;

        if (file_exists(base_path('.env.dusk')))
            return '.env.dusk';

        return 'extensions/igniter/dusk/stubs/.env.dusk';
    }

    protected function duskPhpUnitXmlFile()
    {
        return extension_path('igniter/dusk/stubs/.phpunit.dusk.xml.stub');
    }
}
