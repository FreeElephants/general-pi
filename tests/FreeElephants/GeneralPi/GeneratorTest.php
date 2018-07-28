<?php

namespace FreeElephants\GeneralPi;

use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{

	public function testCreateClassWithNamespace()
	{
		$generator = new Generator();

		$classContainer = $generator->createClass('Fixtures\\Generated\\Foo\\Bar');

		$expectedContent = <<<PHP
namespace Fixtures\Generated\Foo;

/**
 * Generated by free-elephants/general-pi
 */
class Bar
{
}

PHP;
		$this->assertSame($expectedContent, $classContainer->stringify());
	}

	public function testCreateClassInRootNamespace()
	{
		$generator = new Generator();

		$classContainer = $generator->createClass('Bar');

		$expectedContent = <<<PHP
/**
 * Generated by free-elephants/general-pi
 */
class Bar
{
}

PHP;
		$this->assertSame($expectedContent, $classContainer->stringify());
	}

	public function testCreateAbstractWithNamespace()
	{
		$generator = new Generator();

		$classContainer = $generator->createAbstract('Fixtures\\Generated\\Foo\\Bar');

		$expectedContent = <<<PHP
namespace Fixtures\Generated\Foo;

/**
 * Generated by free-elephants/general-pi
 */
abstract class Bar
{
}

PHP;
		$this->assertSame($expectedContent, $classContainer->stringify());
	}

	public function testCreateAbstractInRootNamespace()
	{
		$generator = new Generator();

		$classContainer = $generator->createAbstract('Bar');

		$expectedContent = <<<PHP
/**
 * Generated by free-elephants/general-pi
 */
abstract class Bar
{
}

PHP;
		$this->assertSame($expectedContent, $classContainer->stringify());
	}

	public function testCreateInterfaceWithNamespace()
	{
		$generator = new Generator();

		$classContainer = $generator->createInterface('Fixtures\\Generated\\Foo\\Bar');

		$expectedContent = <<<PHP
namespace Fixtures\Generated\Foo;

/**
 * Generated by free-elephants/general-pi
 */
interface Bar
{
}

PHP;
		$this->assertSame($expectedContent, $classContainer->stringify());
	}

	public function testCreateInterfaceInRootNamespace()
	{
		$generator = new Generator();

		$classContainer = $generator->createInterface('Bar');

		$expectedContent = <<<PHP
/**
 * Generated by free-elephants/general-pi
 */
interface Bar
{
}

PHP;
		$this->assertSame($expectedContent, $classContainer->stringify());
	}

	public function testImplementClassWithNamespace()
	{
		$generator = new Generator();
		$classContainer = $generator->implementClass('Fixtures\\Generated\\Foo\\Bar', 'Fixtures\\FooInterface');

		$expectedContent = <<<PHP
namespace Fixtures\Generated\Foo;

/**
 * Generated by free-elephants/general-pi
 */
class Bar implements \Fixtures\FooInterface
{
    public function foo(\DateTime \$datetime): \Fixtures\FooInterface
    {
    }


    public function bool(bool \$bool = false): bool
    {
    }


    public function main(): void
    {
    }


    public function useConst(string \$const = self::SOME_CONST)
    {
    }
}

PHP;

		$this->assertSame($expectedContent, $classContainer->stringify());
	}

}
