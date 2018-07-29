<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAbstract extends AbstractCreateCommand
{

	protected static $defaultName = 'create:abstract';

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$className = $input->getArgument('className');
		$classContainer = $this->generator->createAbstract($className);
		$this->dump($classContainer->stringify(), $classContainer->getClassFilename());
	}

}
