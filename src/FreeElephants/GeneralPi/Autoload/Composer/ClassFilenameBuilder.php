<?php

namespace FreeElephants\GeneralPi\Autoload\Composer;

use Composer\Factory;
use Composer\IO\NullIO;
use FreeElephants\GeneralPi\Autoload\ClassFilenameBuilderInterface;

class ClassFilenameBuilder implements ClassFilenameBuilderInterface
{

	/**
	 * @var string
	 */
	private $defaultSourcePath;

	private $useDevAutoload = true;

	private const DS = DIRECTORY_SEPARATOR;

	public function __construct(string $defaultSourcePath = 'src', bool $useDevAutoload = true)
	{
		$this->defaultSourcePath = $defaultSourcePath;
		$this->useDevAutoload = $useDevAutoload;
	}

	public function buildFilename(string $className): string
	{
		$composer = Factory::create(new NullIO());
		$rootPackage = $composer->getPackage();

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
					return $this->normalizePath($composerEntry . self::DS . $this->joinToPath($pieces) . self::DS . $basename);
				}
			}

			if ($this->useDevAutoload) {
				$devAutoload = $rootPackage->getDevAutoload();
				foreach ($devAutoload['psr-4'] as $ns => $paths) {
					if (strpos($ns, $nsPattern) === 0) {
						$basename = array_pop($namespaceParts) . '.php';
						$pieces = array_slice($namespaceParts, $position + 1);
						return $paths[0] . $this->joinToPath($pieces) . '/' . $basename;
					}
				}
			}
		}

		return $this->defaultSourcePath . self::DS . $this->joinToPath($namespaceParts) . '.php';
	}

	private function joinToPath(iterable $namespaceParts): string
	{
		return join(self::DS, $namespaceParts);
	}

	private function normalizePath($string): string
	{
		return str_replace(self::DS . self::DS, self::DS, $string);
	}
}
