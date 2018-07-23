<?php

namespace FreeElephants\GeneralPi;

class Generator implements GeneratorInterface
{

    public function createClass(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface {
        // TODO: Implement createClass() method.
    }

    public function createAbstract(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface {
        // TODO: Implement createAbstract() method.
    }

    public function createInterface(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface {
        // TODO: Implement createInterface() method.
    }

    public function createTrait(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface {
        // TODO: Implement createTrait() method.
    }

    public function implementAbstract(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface {
        // TODO: Implement implementAbstract() method.
    }

    public function implementClass(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface {
        // TODO: Implement implementClass() method.
    }

    public function extendAbstract(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface {
        // TODO: Implement extendAbstract() method.
    }

    public function extendClass(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface {
        // TODO: Implement extendClass() method.
    }
}
