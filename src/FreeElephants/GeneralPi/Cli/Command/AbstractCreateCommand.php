<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use FreeElephants\GeneralPi\Autoload\Composer\ClassFilenameBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractCreateCommand extends Command
{
    protected $classFilenameBuilder;
    protected $filesystem;

    protected $classTemplate = <<<PHP
<?php

%s
PHP;

    public function __construct(ClassFilenameBuilder $classFilenameBuilder = null, Filesystem $filesystem = null)
    {
        $this->classFilenameBuilder = $classFilenameBuilder ?: new ClassFilenameBuilder();
        $this->filesystem = $filesystem ?: new Filesystem();
        parent::__construct(self::$defaultName);
        $this->addArgument('className', InputArgument::REQUIRED);
    }

}