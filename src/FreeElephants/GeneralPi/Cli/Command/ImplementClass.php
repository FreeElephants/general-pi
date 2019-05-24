<?php

namespace FreeElephants\GeneralPi\Cli\Command;

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
		Filesystem $filesystem = null
	) {
		parent::__construct($generator, $filesystem);
		$this->addArgument('implementationClassName', InputArgument::REQUIRED | InputArgument::IS_ARRAY);

	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$interfaceName = $input->getArgument('className');
		$implementationClassName = $input->getArgument('implementationClassName');

		$classContainer = $this->generator->implementClass($interfaceName, $implementationClassName);

		$this->dump($classContainer->stringify(), $classContainer->getClassFilename());
	}

}
