<?php

namespace FreeElephants\GeneralPi\Cli\Command;

use FreeElephants\GeneralPi\Autoload\Composer\ClassFilenameBuilder;
use Nette\PhpGenerator\PhpNamespace;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CreateClass extends Command
{

    protected static $defaultName = 'create:class';
    /**
     * @var ClassFilenameBuilder
     */
    private $classFilenameBuilder;
    /**
     * @var Filesystem
     */
    private $filesystem;

    private $classTemplate = <<<PHP
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

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $className = $input->getArgument('className');
        $filename = $this->classFilenameBuilder->buildFilename($className);
        $namespaceParts = explode('\\', $className);
        $shortClassName = array_pop($namespaceParts);
        $namespace = new PhpNamespace(join('\\', $namespaceParts));
        $class = $namespace->addClass($shortClassName);

        $fileContent = sprintf($this->classTemplate, $namespace->__toString());
        $this->filesystem->dumpFile($filename, $fileContent);
    }
}
