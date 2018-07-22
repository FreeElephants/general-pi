<?php

namespace FreeElephants\GeneralPi\Autoload\Composer;

use PHPUnit\Framework\TestCase;

class ClassFilenameBuilderTest extends TestCase
{

    public function testBuildFilenameForExistingClass()
    {
        $builder = new ClassFilenameBuilder();
        $className = ClassFilenameBuilder::class;

        $filename = $builder->buildFilename($className);

        $this->assertSame('src/FreeElephants/GeneralPi/Autoload/Composer/ClassFilenameBuilder.php', $filename);
    }

    public function testBuildFilename()
    {
        $builder = new ClassFilenameBuilder();
        $className = 'FreeElephants\\GeneralPi\\Foo';

        $filename = $builder->buildFilename($className);

        $this->assertSame('src/FreeElephants/GeneralPi/Foo.php', $filename);
    }

    public function testBuildFilename2()
    {
        $builder = new ClassFilenameBuilder();
        $className = 'FreeElephants\\GeneralPi\\Foo\\Bar';

        $filename = $builder->buildFilename($className);

        $this->assertSame('src/FreeElephants/GeneralPi/Foo/Bar.php', $filename);
    }

    public function testBuildFilenameInDev()
    {
        $builder = new ClassFilenameBuilder();
        $className = 'Fixtures\\Foo\\Bar';

        $filename = $builder->buildFilename($className);

        $this->assertSame('tests/Fixtures/Foo/Bar.php', $filename);
    }

    public function testDefaultRootPath()
    {
        $builder = new ClassFilenameBuilder();
        $className = 'SomePackageName\\Foo\\Bar\\Baz';

        $filename = $builder->buildFilename($className);

        $this->assertSame('src/SomePackageName/Foo/Bar/Baz.php', $filename);
    }
}

