<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use FreeElephants\GeneralPi\Autoload\Composer\ClassFilenameBuilder;
use FreeElephants\GeneralPi\Generator;
use FreeElephants\GeneralPi\GeneratorInterface;
use Nette\PhpGenerator\Helpers;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractCreateCommand extends Command
{
	protected $classFilenameBuilder;

	protected $filesystem;

	/**
	 * @var GeneratorInterface
	 */
	protected $generator;

	protected $classTemplate = <<<PHP
<?php

%s
PHP;

	public function __construct(
		GeneratorInterface $generator = null,
		ClassFilenameBuilder $classFilenameBuilder = null,
		Filesystem $filesystem = null
	) {
		$this->classFilenameBuilder = $classFilenameBuilder ?: new ClassFilenameBuilder();
		$this->filesystem = $filesystem ?: new Filesystem();
		$this->generator = $generator ?: new Generator();

		parent::__construct(self::$defaultName);
		$this->addArgument('className', InputArgument::REQUIRED);
	}


	/**
	 * @param $content
	 * @param $filename
	 */
	protected function dump(string $content, string $filename): void
	{
		$content = sprintf($this->classTemplate, $content);
		$this->filesystem->dumpFile($filename, $content);
	}
}
