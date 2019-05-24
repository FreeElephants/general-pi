<?php

namespace FreeElephants\GeneralPi\Nette;

use FreeElephants\GeneralPi\Autoload\ClassFilenameBuilderInterface;
use FreeElephants\GeneralPi\Autoload\Composer\ClassFilenameBuilder;
use FreeElephants\GeneralPi\ClassContainerInterface;
use FreeElephants\GeneralPi\CreateOptionsInterface;
use FreeElephants\GeneralPi\GeneratorInterface;
use Nette\PhpGenerator\PhpLiteral;
use Nette\PhpGenerator\PhpNamespace;

class Generator implements GeneratorInterface
{

	/**
	 * @var ClassFilenameBuilderInterface
	 */
	private $classFilenameBuilder;

	public function __construct(ClassFilenameBuilderInterface $classFilenameBuilder = null)
	{
		$this->classFilenameBuilder = $classFilenameBuilder ?: new ClassFilenameBuilder();
	}

	public function createClass(
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
		$namespaceParts = explode('\\', $className);
		$shortClassName = array_pop($namespaceParts);
		$namespace = new PhpNamespace(join('\\', $namespaceParts));

		$class = $namespace->addClass($shortClassName);
		$class->addComment(self::GENERATED_BY_COMMENT);

		return $this->createClassContainer($className, $namespace);
	}


	public function createAbstract(
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
		$namespaceParts = explode('\\', $className);
		$shortClassName = array_pop($namespaceParts);
		$namespace = new PhpNamespace(join('\\', $namespaceParts));

		$class = $namespace->addClass($shortClassName);
		$class->setAbstract();
		$class->addComment(self::GENERATED_BY_COMMENT);

		return $this->createClassContainer($className, $namespace);
	}


	public function createInterface(
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
		$namespaceParts = explode('\\', $className);
		$shortClassName = array_pop($namespaceParts);
		$namespace = new PhpNamespace(join('\\', $namespaceParts));
		$class = $namespace->addInterface($shortClassName);
		$class->addComment(self::GENERATED_BY_COMMENT);

		return $this->createClassContainer($className, $namespace);
	}


	public function createTrait(
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
	}


	public function implementAbstract(
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
	}


	public function implementClass(
		string $interfaceName,
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
		$namespaceParts = explode('\\', $className);
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
					if ($parameterReflection->isDefaultValueConstant()) {
						$parameter->setDefaultValue(new PhpLiteral($parameterReflection->getDefaultValueConstantName()));
					} else {
						$parameter->setDefaultValue($parameterReflection->getDefaultValue());
					}
				}
			}
		}

		return $this->createClassContainer($className, $namespace);
	}


	public function extendAbstract(
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
	}


	public function extendClass(
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
	}

	/**
	 * @param string $className
	 * @param $namespace
	 * @return ClassContainer
	 */
	protected function createClassContainer(string $className, PhpNamespace $namespace): ClassContainer
	{
		$classContainer = new ClassContainer($namespace);
		$filename = $this->classFilenameBuilder->buildFilename($className);
		$classContainer->setClassFilename($filename);

		return $classContainer;
	}
}
