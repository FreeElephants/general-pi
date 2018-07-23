<?php

namespace FreeElephants\GeneralPi;

interface GeneratorInterface
{

    public function createClass(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface;

    public function createAbstract(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface;

    public function createInterface(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface;

    public function createTrait(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface;

    public function implementAbstract(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface;

    public function implementClass(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface;

    public function extendAbstract(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface;

    public function extendClass(
        string $className,
        CreateOptionsInterface $createOptions = null
    ): ClassContainerInterface;

}
