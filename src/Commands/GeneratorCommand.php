<?php

declare(strict_types=1);

namespace Igniter\Dusk\Commands;

use Illuminate\Support\Str;
use Override;

abstract class GeneratorCommand extends \Illuminate\Console\GeneratorCommand
{
    protected $extensionNamespace;

    #[Override]
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
    #[Override]
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace().'\\', '', $name);
        $name = str_replace('\\', '/', $name);
        $name = Str::lower(Str::beforeLast($name, '/')).'/'.Str::afterLast($name, '/');

        [$vendor, $author] = $this->extensionNamespace;

        return extension_path(strtolower((string) $vendor).'/'.strtolower((string) $author).'/tests/'.$name.'.php');
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    #[Override]
    protected function rootNamespace()
    {
        if ($this->extensionNamespace) {
            [$vendor, $author] = $this->extensionNamespace;

            return sprintf('%s\\%s\\Tests', title_case($vendor), title_case($author));
        }

        return 'Tests';
    }
}
