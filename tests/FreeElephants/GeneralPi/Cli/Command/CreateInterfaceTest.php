<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use Symfony\Component\Console\Tester\CommandTester;

class CreateInterfaceTest extends AbstractCreateCommandTest
{

    public function testExecuteWithFilename()
    {
        $fixtureFilename = self::GENERATED_FIXTURE_PATH . '/Foo/Bar.php';
        $this->assertFileNotExists($fixtureFilename);

        $cmd = $this->createCommand(CreateInterface::class, 'create:interface');
        $commandTester = new CommandTester($cmd);
        $commandTester->execute([
            'command' => $cmd->getName(),
            'className' => 'Fixtures\\Generated\\Foo\\Bar',
        ]);

        $this->assertFileExists($fixtureFilename);

        $expectedFileContent = <<<PHP
<?php

namespace Fixtures\Generated\Foo;

interface Bar
{
}

PHP;
        $actualFileContent = file_get_contents($fixtureFilename);
        $this->assertSame($expectedFileContent, $actualFileContent);
    }
}
