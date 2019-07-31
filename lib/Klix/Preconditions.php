<?php

namespace Klix;

use InvalidArgumentException;

class Preconditions
{

	/**
	 * @param $arg mixed
	 * @param $errorMessage string
	 * @return mixed
	 */
	public static function checkNotNull($arg, $errorMessage)
	{
		if ($arg === null || (is_array($arg) && count($arg) === 0)) {
			throw new InvalidArgumentException($errorMessage);
		}
		return $arg;
	}
}
