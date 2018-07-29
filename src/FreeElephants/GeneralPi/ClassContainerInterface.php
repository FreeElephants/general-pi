<?php

namespace FreeElephants\GeneralPi;

interface ClassContainerInterface
{

	public function setClassFilename(string $filename);

	public function getClassFilename(): string;

	public function stringify(): string;

	/**
	 * @internal use stringify()
	 */
	public function __toString(): string;
}
