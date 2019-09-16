<?php

namespace Klix\Merchant;

class Company extends Model
{
	/**
	 * @return string
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

	/**
	 * @return string
	 */
    public function getAddress()
    {
        return $this->values['address'];
    }

	/**
	 * @param $address string
	 * @return $this
	 */
    public function setAddress($address)
    {
        $this->values['address'] = $address;
        return $this;
    }

	/**
	 * @return string
	 */
	public function getRegistrationNumber()
	{
		return $this->values['registration_number'];
	}

	/**
	 * @param $registrationNumber string
	 * @return $this
	 */
	public function setRegistrationNumber($registrationNumber)
	{
		$this->values['registration_number'] = $registrationNumber;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getVatNumber()
	{
		return $this->values['vat_number'];
	}

	/**
	 * @param $vatNumber string
	 * @return $this
	 */
	public function setVatNumber($vatNumber)
	{
		$this->values['vat_number'] = $vatNumber;
		return $this;
	}
}
