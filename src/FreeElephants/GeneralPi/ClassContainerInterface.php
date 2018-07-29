<?php

namespace FreeElephants\GeneralPi;

interface ClassContainerInterface
{

	public function stringify(): string;

	/**
	 * @internal use stringify()
	 */
	public function __toString(): string;
}
