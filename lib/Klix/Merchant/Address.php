<?php

namespace Klix\Merchant;

class Address extends Model
{
	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this->values['city'];
	}

	/**
	 * @param $city string
	 * @return $this
	 */
	public function setCity($city)
	{
		$this->values['city'] = $city;
		return $this;
	}

	/**
	 * @return string
	 */
    public function getCountry()
    {
        return $this->values['country'];
    }

	/**
	 * @param $country string
	 * @return $this
	 */
    public function setCountry($country)
    {
        $this->values['country'] = $country;
        return $this;
    }

	/**
	 * @return float
	 */
	public function getLatitude()
	{
		return $this->values['latitude'];
	}

	/**
	 * @param float $latitude
	 * @return $this
	 */
	public function setLatitude($latitude)
	{
		$this->values['latitude'] = $latitude;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getLongitude()
	{
		return $this->values['longitude'];
	}

	/**
	 * @param float $longitude
	 * @return $this
	 */
	public function setLongitude($longitude)
	{
		$this->values['longitude'] = $longitude;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPostalCode()
	{
		return $this->values['postal_code'];
	}

	/**
	 * @param $postalCode string
	 * @return $this
	 */
	public function setPostalCode($postalCode)
	{
		$this->values['postal_code'] = $postalCode;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreet()
	{
		return $this->values['street'];
	}

	/**
	 * @param $street string
	 * @return $this
	 */
	public function setStreet($street)
	{
		$this->values['street'] = $street;
		return $this;
	}
}
