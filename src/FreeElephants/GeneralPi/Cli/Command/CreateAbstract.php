<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use Nette\PhpGenerator\PhpNamespace;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAbstract extends AbstractCreateCommand
{

	protected static $defaultName = 'create:abstract';

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$className = $input->getArgument('className');
		$filename = $this->classFilenameBuilder->buildFilename($className);
		$namespaceParts = explode('\\', $className);
		$shortClassName = array_pop($namespaceParts);
		$namespace = new PhpNamespace(join('\\', $namespaceParts));

		$class = $namespace->addClass($shortClassName);
		$class->setAbstract();
		$class->addComment(self::GENERATED_BY_COMMENT);

		$this->dump($namespace, $filename);
	}

}
