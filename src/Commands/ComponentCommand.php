<?php

declare(strict_types=1);

namespace Igniter\Dusk\Commands;

use Override;

class ComponentCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dusk:component {extension : The name of the extension} {name : The name of the class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Dusk component class for a TastyIgniter extension';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Component';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    #[Override]
    protected function getStub()
    {
        return __DIR__.'/stubs/component.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    #[Override]
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Components';
    }
}
