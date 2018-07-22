<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

class CreateInterfaceTest extends TestCase
{

    const GENERATED_FIXTURE_PATH = 'tests/Fixtures/Generated';

    protected function setUp()
    {
        (new Filesystem())->remove(glob(self::GENERATED_FIXTURE_PATH . '/*'));
        parent::setUp();
    }

    public function testExecuteWithFilename()
    {
        $fixtureFilename = self::GENERATED_FIXTURE_PATH . '/Foo/Bar.php';
        $this->assertFileNotExists($fixtureFilename);

        $application = new Application();
        $application->add(new CreateInterface());
        $cmd = $application->find('create:interface');

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
