<?php

declare(strict_types=1);

namespace Igniter\Dusk\Commands;

class PageCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dusk:page {extension : The name of the extension} {name : The name of the class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Dusk page class for a TastyIgniter extension';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Page';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/page.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Pages';
    }
}
