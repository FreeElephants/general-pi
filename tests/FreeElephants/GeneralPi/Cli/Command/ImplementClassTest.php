<?php

namespace FreeElephants\GeneralPi\Cli\Command;

class ImplementClassTest extends AbstractCreateCommandTest
{

    public function testExecuteSuccess()
    {
        $cmd = $this->createCommand(ImplementClass::class, 'implement:class');
        $this->assertTrue(true);
    }

}
