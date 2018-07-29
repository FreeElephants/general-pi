<?php

namespace FreeElephants\GeneralPi\Autoload;

interface ClassFilenameBuilderInterface
{
	public function buildFilename(string $className): string;
}
