<?php namespace Igniter\Dusk;

use Igniter\System\Classes\BaseExtension;

/**
 * Dusk Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Register method, called when the extension is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(DuskServiceProvider::class);
    }
}
