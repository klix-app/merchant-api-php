<?php

namespace Klix\Merchant;

class Shipping extends Model
{

	/**
	 * @return ShippingMethod
	 */
	public function getMethod()
	{
		return new ShippingMethod($this->values['method']);
	}

	/**
	 * @param $shipmentMethod ShippingMethod
	 * @return $this
	 */
	public function setMethod($shipmentMethod)
	{
		$this->values['method'] = $shipmentMethod->getValues();
		return $this;
	}

	/**
	 * @return Address
	 */
	public function getAddress()
	{
		return new Address($this->values['address']);
	}

	/**
	 * @param $address Address
	 * @return $this
	 */
	public function setAddress($address)
	{
		$this->values['address'] = $address->getValues();
		return $this;
	}

	/**
	 * @return PickupPoint
	 */
	public function getPickupPoint()
	{
		return new PickupPoint($this->values['pickup_point']);
	}

	/**
	 * @param $address PickupPoint
	 * @return $this
	 */
	public function setPickupPoint($address)
	{
		$this->values['pickup_point'] = $address->getValues();
		return $this;
	}

	/**
	 * @return string
	 */
    public function getContactPhone()
    {
        return $this->values['contact_phone'];
    }

	/**
	 * @param $contactPhone string
	 * @return $this
	 */
    public function setContactPhone($contactPhone)
    {
        $this->values['contact_phone'] = $contactPhone;
        return $this;
    }

	/**
	 * @return string Preferable delivery date in format "yyyy-MM-dd"
	 */
	public function getDate()
	{
		return $this->values['date'];
	}

	/**
	 * @param string $date
	 * @return $this
	 */
	public function setDate($date)
	{
		$this->values['date'] = $date;
		return $this;
	}

	/**
	 * @return string Shipment type. Possible values: ADDRESS, PICKUP_POINT
	 */
	public function getType()
	{
		return $this->values['type'];
	}

	/**
	 * @param $type string
	 * @return $this
	 */
	public function setType($type)
	{
		$this->values['type'] = $type;
		return $this;
	}
}
