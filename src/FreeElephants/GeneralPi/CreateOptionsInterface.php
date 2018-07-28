<?php

namespace FreeElephants\GeneralPi;

interface CreateOptionsInterface
{

	public function checkClassExists(): bool;

	public function getDefaultPath(): string;

	public function getParents(): iterable;

	public function isOverwriteEnable(): bool;
}
