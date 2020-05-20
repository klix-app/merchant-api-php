<?php

namespace Klix\Api;

class Customer extends Model
{
	/**
	 * @return string
	 */
    public function getEmail()
    {
        return $this->values['email'];
    }

	/**
	 * @param $email string
	 * @return $this
	 */
    public function setEmail($email)
    {
        $this->values['email'] = $email;
        return $this;
    }

	/**
	 * @return string
	 */
    public function getFirstName()
    {
        return $this->values['first_name'];
    }

	/**
	 * @param $firstName string
	 * @return $this
	 */
    public function setFirstName($firstName)
    {
        $this->values['first_name'] = $firstName;
        return $this;
    }

	/**
	 * @return string
	 */
	public function getLastName()
	{
		return $this->values['last_name'];
	}

	/**
	 * @param $lastName string
	 * @return $this
	 */
	public function setLastName($lastName)
	{
		$this->values['last_name'] = $lastName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhoneNumber()
	{
		return $this->values['phone_number'];
	}

	/**
	 * @param $phoneNumber string
	 * @return $this
	 */
	public function setPhoneNumber($phoneNumber)
	{
		$this->values['phone_number'] = $phoneNumber;
		return $this;
	}
}
