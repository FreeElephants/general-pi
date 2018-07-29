<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use FreeElephants\GeneralPi\Autoload\ClassFilenameBuilderInterface;
use FreeElephants\GeneralPi\GeneratorInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImplementClass extends AbstractCreateCommand
{

	protected static $defaultName = 'implement:class';

	public function __construct(
		GeneratorInterface $generator = null,
		ClassFilenameBuilderInterface $classFilenameBuilder = null,
		Filesystem $filesystem = null
	) {
		parent::__construct($generator, $classFilenameBuilder, $filesystem);
		$this->addArgument('implementationClassName', InputArgument::REQUIRED);
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$interfaceName = $input->getArgument('className');
		$implementationClassName = $input->getArgument('implementationClassName');
		$implementationFilename = $this->classFilenameBuilder->buildFilename($implementationClassName);

		$classContainer = $this->generator->implementClass($implementationClassName, $interfaceName);

		$this->dump($classContainer->stringify(), $implementationFilename);
	}

}
