<?php

declare(strict_types=1);

namespace Igniter\Dusk\Concerns;

use ReflectionClass;
use InvalidArgumentException;
use RuntimeException;
use Artisan;
use Igniter\System\Classes\ExtensionManager;
use Igniter\System\Classes\UpdateManager;

trait TestsExtensions
{
    /**
     * @var array Cache for storing which extensions have been loaded
     * and refreshed.
     */
    protected $testCaseLoadedExtensions = [];

    public function resetManagers(): void
    {
        ExtensionManager::forgetInstance();
        UpdateManager::forgetInstance();
    }

    /**
     * Detects the current extension based on the namespace,
     * when running tests within a extension.
     */
    public function detectExtension(): void
    {
        $this->testCaseLoadedExtensions = [];

        if ($extensionCode = $this->guessExtensionCodeFromTest()) {
            $this->runExtensionRefreshCommand($extensionCode, false);
        }
    }

    /**
     * Detects the current extension dependencies based on the namespace,
     * when running tests within a extension.
     */
    protected function detectExtensionDependencies($extension): void
    {
        foreach ((array)$extension->require as $dependency) {
            if (isset($this->testCaseLoadedExtensions[$dependency])) {
                continue;
            }

            $this->runExtensionRefreshCommand($dependency);
        }
    }

    /**
     * Locates the extension code based on the test file location.
     */
    protected function guessExtensionCodeFromTest(): string|false
    {
        $reflect = new ReflectionClass($this);
        $path = $reflect->getFilename();
        $basePath = $this->app->extensionsPath();

        $result = false;

        if (strpos($path, $basePath) === 0) {
            $result = ltrim(str_replace('\\', '/', substr($path, strlen($basePath))), '/');
            $result = implode('.', array_slice(explode('/', $result), 0, 2));
        }

        return $result;
    }

    /**
     * Runs a refresh command on a extension.
     *
     * @param bool $throwException
     */
    protected function runExtensionRefreshCommand($code, $throwException = true): void
    {
        if (!preg_match('/^[\w+]*\.[\w+]*$/', $code)) {
            if (!$throwException) {
                return;
            }

            throw new InvalidArgumentException(sprintf('Invalid extension code: "%s"', $code));
        }

        $extensionManager = resolve(ExtensionManager::class);

        if (!$extension = $extensionManager->findExtension($code)) {
            $namespace = '\\'.str_replace('.', '\\', strtolower($code));
            $path = array_get($extensionManager->namespaces(), $namespace);

            if (!$path) {
                if (!$throwException) {
                    return;
                }

                throw new RuntimeException(sprintf('Unable to find extension with code: "%s"', $code));
            }

            $extension = $extensionManager->loadExtension($namespace);
        }

        $this->testCaseLoadedExtensions[$code] = $extension;

        $this->detectExtensionDependencies($extension);

        // Execute the command
        Artisan::call('extension:refresh', ['name' => $code]);
    }
}
