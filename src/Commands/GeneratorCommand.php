<?php

declare(strict_types=1);

namespace Igniter\Dusk\Commands;

use Illuminate\Support\Str;

abstract class GeneratorCommand extends \Illuminate\Console\GeneratorCommand
{
    protected $extensionNamespace;

    public function handle()
    {
        $code = $this->argument('extension');
        if (count($array = explode('.', $code)) != 2) {
            $this->error('Invalid extension name, Example name: AuthorName.ExtensionName');

            return null;
        }

        $this->extensionNamespace = $array;

        return parent::handle();
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace().'\\', '', $name);
        $name = str_replace('\\', '/', $name);
        $name = Str::lower(Str::beforeLast($name, '/')).'/'.Str::afterLast($name, '/');

        [$vendor, $author] = $this->extensionNamespace;

        return extension_path(strtolower($vendor).'/'.strtolower($author).'/tests/'.$name.'.php');
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        if ($this->extensionNamespace) {
            [$vendor, $author] = $this->extensionNamespace;

            return sprintf('%s\\%s\\Tests', title_case($vendor), title_case($author));
        }

        return 'Tests';
    }
}
