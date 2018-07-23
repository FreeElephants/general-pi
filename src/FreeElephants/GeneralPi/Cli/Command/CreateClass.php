<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use FreeElephants\GeneralPi\Autoload\Composer\ClassFilenameBuilder;
use Nette\PhpGenerator\PhpNamespace;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CreateClass extends AbstractCreateCommand
{

    protected static $defaultName = 'create:class';

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $className = $input->getArgument('className');
        $filename = $this->classFilenameBuilder->buildFilename($className);
        $namespaceParts = explode('\\', $className);
        $shortClassName = array_pop($namespaceParts);
        $namespace = new PhpNamespace(join('\\', $namespaceParts));
        $namespace->addClass($shortClassName);

        $fileContent = sprintf($this->classTemplate, $namespace->__toString());
        $this->filesystem->dumpFile($filename, $fileContent);
    }
}
