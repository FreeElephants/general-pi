<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateInterface extends AbstractCreateCommand
{

	protected static $defaultName = 'create:interface';

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$className = $input->getArgument('className');
		$filename = $this->classFilenameBuilder->buildFilename($className);

		$classContainer = $this->generator->createInterface($className);

		$this->dump($classContainer->stringify(), $filename);
	}
}
