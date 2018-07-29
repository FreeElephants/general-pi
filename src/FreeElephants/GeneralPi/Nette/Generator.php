<?php

namespace FreeElephants\GeneralPi\Nette;

use FreeElephants\GeneralPi\ClassContainerInterface;
use FreeElephants\GeneralPi\CreateOptionsInterface;
use FreeElephants\GeneralPi\GeneratorInterface;
use Nette\PhpGenerator\PhpLiteral;
use Nette\PhpGenerator\PhpNamespace;

class Generator implements GeneratorInterface
{
	public function createClass(
		string $className,
		CreateOptionsInterface $createOptions = null
	): ClassContainerInterface {
		$namespaceParts = explode('\\', $className);
		$shortClassName = array_pop($namespaceParts);
		$namespace = new PhpNamespace(join('\\', $namespaceParts));

		$class = $namespace->addClass($shortClassName);
		$class->addComment(self::GENERATED_BY_COMMENT);
		return new ClassContainer($namespace);
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

		return new ClassContainer($namespace);
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

		return new ClassContainer($namespace);
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
		string $className,
		string $interfaceName,
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

		return new ClassContainer($namespace);
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
}
