<?php

namespace Klix\Merchant;

abstract class Model
{
	/**
	 * @var mixed[]
	 */
	protected $values = [];

	/**
	 * @param mixed[] $values
	 */
	public function __construct(array $values)
	{
		$this->values = $values;
	}

	/**
	 * Gets the string presentation of the object
	 *
	 * @return string
	 */
	public function __toString()
	{
		if (defined('JSON_PRETTY_PRINT')) {
			return json_encode($this->values, JSON_PRETTY_PRINT);
		}

		return json_encode($this->values);
	}

	/**
	 * @return mixed[]
	 */
	public function getValues() {
		return $this->values;
	}
}
