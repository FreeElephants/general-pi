<?php

namespace Fixtures;

interface FooInterface
{

    const SOME_CONST = 'foo';

    function foo(\DateTime $datetime): FooInterface;

    public function bool(bool $bool = false): bool;

    public function main(): void;

    public function useConst(string $const = self::SOME_CONST);
}
