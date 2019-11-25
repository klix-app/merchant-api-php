<?php

namespace Klix\Merchant;

class ShippingMethod extends Model
{
	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->values['id'];
	}

	/**
	 * @param $id string
	 * @return $this
	 */
	public function setId($id)
	{
		$this->values['id'] = $id;
		return $this;
	}

	/**
	 * @return name
	 */
	public function getName()
	{
		return $this->values['name'];
	}

	/**
	 * @param $name string
	 * @return $this
	 */
	public function setName($name)
	{
		$this->values['name'] = $name;
		return $this;
	}
}
