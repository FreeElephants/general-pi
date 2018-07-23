<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractCreateCommandTest extends TestCase
{
    const GENERATED_FIXTURE_PATH = 'tests/Fixtures/Generated';

    protected function setUp()
    {
        (new Filesystem())->remove(glob(self::GENERATED_FIXTURE_PATH . '/*'));
        parent::setUp();
    }


    protected function createCommand(string $className, string $commandName): Command
    {
        $application = new Application();
        $application->add(new $className);
        return $application->find($commandName);
    }
}
