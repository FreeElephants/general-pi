<?php

namespace FreeElephants\GeneralPi\Autoload\Composer;

use Composer\Factory;
use Composer\IO\NullIO;

class ClassFilenameBuilder
{

    /**
     * @var string
     */
    private $defaultSourcePath;

    private $useDevAutoload = true;

    public function __construct(string $defaultSourcePath = 'src')
    {
        $this->defaultSourcePath = $defaultSourcePath;
    }

    public function buildFilename($className): string
    {
        $composer = Factory::create(new NullIO());
        $rootPackage = $composer->getPackage();
        $devAutoload = $rootPackage->getDevAutoload();

        $autoloads = $rootPackage->getAutoload();

        $namespaceParts = explode('\\', $className);
        $nsPattern = '';
        foreach ($namespaceParts as $position => $part) {
            $nsPattern .= $part . '\\';
            foreach ($autoloads['psr-4'] as $ns => $paths) {
                if (strpos($ns, $nsPattern) === 0) {
                    $shortClassName = array_pop($namespaceParts);

                    $composerEntry = $paths[0];
                    $basename = $shortClassName . '.php';
                    $pieces = array_slice($namespaceParts, $position + 2);
                    return $this->normalizePath($composerEntry . DIRECTORY_SEPARATOR . $this->joinToPath($pieces) . DIRECTORY_SEPARATOR . $basename);
                }
            }

            if ($this->useDevAutoload) {
                foreach ($devAutoload['psr-4'] as $ns => $paths) {
                    if (strpos($ns, $nsPattern) === 0) {
                        $basename = array_pop($namespaceParts) . '.php';
                        $pieces = array_slice($namespaceParts, $position + 1);
                        return $paths[0] . $this->joinToPath($pieces) . '/' . $basename;
                    }
                }
            }


        }

        return $this->defaultSourcePath . DIRECTORY_SEPARATOR . $this->joinToPath($namespaceParts) . '.php';
    }

    private function joinToPath(iterable $namespaceParts): string
    {
        return join(DIRECTORY_SEPARATOR, $namespaceParts);
    }

    private function normalizePath($string): string
    {
        return str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $string);
    }
}
