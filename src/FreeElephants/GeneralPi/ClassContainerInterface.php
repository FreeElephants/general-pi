<?php

namespace FreeElephants\GeneralPi;

interface ClassContainerInterface
{

	public function stringify(): string;

	/**
	 * @internal use
	 */
	public function __toString(): string;
}
