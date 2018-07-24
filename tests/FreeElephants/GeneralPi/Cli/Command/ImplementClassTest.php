<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use Symfony\Component\Console\Tester\CommandTester;

class ImplementClassTest extends AbstractCreateCommandTest
{

    public function testExecuteSuccess()
    {
        $fixtureFilename = self::GENERATED_FIXTURE_PATH . '/Foo/Bar.php';
        $this->assertFileNotExists($fixtureFilename);

        $cmd = $this->createCommand(ImplementClass::class, 'implement:class');

        $commandTester = new CommandTester($cmd);
        $commandTester->execute([
            'command' => $cmd->getName(),
            'implementationClassName' => 'Fixtures\\Generated\\Foo\\Bar',
            'className' => 'Fixtures\\FooInterface'
        ]);

        $this->assertFileExists($fixtureFilename);

        $expectedFileContent = <<<PHP
<?php

namespace Fixtures\Generated\Foo;

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
        $actualFileContent = file_get_contents($fixtureFilename);
        $this->assertSame($expectedFileContent, $actualFileContent);
    }

}
