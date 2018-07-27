<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use FreeElephants\GeneralPi\Autoload\Composer\ClassFilenameBuilder;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpLiteral;
use Nette\PhpGenerator\PhpNamespace;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImplementClass extends AbstractCreateCommand
{

    protected static $defaultName = 'implement:class';

	public function __construct(ClassFilenameBuilder $classFilenameBuilder = null, Filesystem $filesystem = null)
    {
        parent::__construct($classFilenameBuilder, $filesystem);
        $this->addArgument('implementationClassName', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $interfaceName = $input->getArgument('className');
        $implementationClassName = $input->getArgument('implementationClassName');
        $implementationFilename = $this->classFilenameBuilder->buildFilename($implementationClassName);

        $namespaceParts = explode('\\', $implementationClassName);
        $shortClassName = array_pop($namespaceParts);
        $namespace = new PhpNamespace(join('\\', $namespaceParts));
        $implementationClass = $namespace->addClass($shortClassName);

        $implementationClass->addImplement($interfaceName);
        $implementationClass->addComment(self::GENERATED_BY_COMMENT);
        $interfaceReflection = new \ReflectionClass($interfaceName);
        $interfaceMethods = $interfaceReflection->getMethods();
        foreach ($interfaceMethods as $methodReflection) {
            $method = $implementationClass->addMethod($methodReflection->getName())
                ->setReturnType($methodReflection->getReturnType());
            foreach ($methodReflection->getParameters() as $parameterReflection) {
                $parameterName = $parameterReflection->getName();
                $typeHint = $parameterReflection->getType()->getName();
                $parameter = $method->addParameter($parameterName)->setTypeHint($typeHint);
                if ($parameterReflection->isDefaultValueAvailable()) {
                    if($parameterReflection->isDefaultValueConstant()) {
                        $parameter->setDefaultValue(new PhpLiteral($parameterReflection->getDefaultValueConstantName()));
                    } else {
                        $parameter->setDefaultValue($parameterReflection->getDefaultValue());
                    }

                }
            }

        }

        $classContent = Helpers::tabsToSpaces($namespace->__toString(), 4);
        $fileContent = sprintf($this->classTemplate, $classContent);

        $this->filesystem->dumpFile($implementationFilename, $fileContent);
    }

}
