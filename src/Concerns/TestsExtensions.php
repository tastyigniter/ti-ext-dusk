<?php

namespace Igniter\Dusk\Concerns;

use Igniter\Flame\Exception\SystemException;
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
     *
     * @return void
     */
    public function detectExtension(): void
    {
        $this->testCaseLoadedExtensions = [];

        if ($extensionCode = $this->guessExtensionCodeFromTest())
            $this->runExtensionRefreshCommand($extensionCode, false);
    }

    /**
     * Detects the current extension dependencies based on the namespace,
     * when running tests within a extension.
     *
     * @param $extension
     */
    protected function detectExtensionDependencies($extension): void
    {
        foreach ((array)$extension->require as $dependency) {
            if (isset($this->testCaseLoadedExtensions[$dependency]))
                continue;

            $this->runExtensionRefreshCommand($dependency);
        }
    }

    /**
     * Locates the extension code based on the test file location.
     *
     * @return string|bool
     */
    protected function guessExtensionCodeFromTest()
    {
        $reflect = new \ReflectionClass($this);
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
     * @param $code
     * @param bool $throwException
     * @return void
     */
    protected function runExtensionRefreshCommand($code, $throwException = true): void
    {
        if (!preg_match('/^[\w+]*\.[\w+]*$/', $code)) {
            if (!$throwException)
                return;

            throw new SystemException(sprintf('Invalid extension code: "%s"', $code));
        }

        $extensionManager = resolve(ExtensionManager::class);

        if (!$extension = $extensionManager->findExtension($code)) {
            $namespace = '\\'.str_replace('.', '\\', strtolower($code));
            $path = array_get($extensionManager->namespaces(), $namespace);

            if (!$path) {
                if (!$throwException)
                    return;

                throw new SystemException(sprintf('Unable to find extension with code: "%s"', $code));
            }

            $extension = $extensionManager->loadExtension($namespace, $path);
        }

        $this->testCaseLoadedExtensions[$code] = $extension;

        $this->detectExtensionDependencies($extension);

        // Execute the command
        \Artisan::call('extension:refresh', ['name' => $code]);
    }
}
