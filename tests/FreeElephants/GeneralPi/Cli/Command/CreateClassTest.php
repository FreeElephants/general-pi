<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class CreateClassTest extends AbstractCreateCommandTest
{

    public function testExecuteWithFilename()
    {
        $fixtureFilename = self::GENERATED_FIXTURE_PATH . '/Foo/Bar.php';
        $this->assertFileNotExists($fixtureFilename);

        $cmd = $this->createCommand(CreateClass::class, 'create:class');

        $commandTester = new CommandTester($cmd);
        $commandTester->execute([
            'command' => $cmd->getName(),
            'className' => 'Fixtures\\Generated\\Foo\\Bar',
        ]);

        $this->assertFileExists($fixtureFilename);

        $expectedFileContent = <<<PHP
<?php

namespace Fixtures\Generated\Foo;

class Bar
{
}

PHP;
        $actualFileContent = file_get_contents($fixtureFilename);
        $this->assertSame($expectedFileContent, $actualFileContent);
    }

    public function testExceptionOnRequiredArgument()
    {
        $cmd = $this->createCommand(CreateClass::class, 'create:class');

        $commandTester = new CommandTester($cmd);

        $this->expectException(RuntimeException::class);
        $commandTester->execute([
            'command' => $cmd->getName(),
        ]);
    }
}
