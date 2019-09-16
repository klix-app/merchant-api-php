<?php

namespace Klix\Merchant;

class OrderItem extends Model
{
    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->values['amount'];
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->values['amount'] = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->values['name'];
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->values['name'] = $name;
        return $this;
    }

	/**
	 * @return float
	 */
	public function getQuantity()
	{
		return $this->values['quantity'];
	}

	/**
	 * @param float $quantity
	 * @return $this
	 */
	public function setQuantity($quantity)
	{
		$this->values['quantity'] = $quantity;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getReference()
	{
		return $this->values['reference'];
	}

	/**
	 * @param string $reference
	 * @return $this
	 */
	public function setReference($reference)
	{
		$this->values['reference'] = $reference;
		return $this;
	}

    /**
     * @return float
     */
    public function getTaxRate()
    {
        return $this->values['tax_rate'];
    }

    /**
     * @param float $taxRate
     * @return $this
     */
    public function setTaxRate($taxRate)
    {
        $this->values['tax_rate'] = $taxRate;
        return $this;
    }

	/**
	 * @return string Order item type. Possible values: PHYSICAL_GOODS, DIGITAL_GOODS, SHIPPING, UNKNOWN
	 */
	public function getType()
	{
		return $this->values['type'];
	}

	/**
	 * @param string $type
	 * @return $this
	 */
	public function setType($type)
	{
		$this->values['type'] = $type;
		return $this;
	}

	/**
	 * @return string Order item unit. Possible values: PIECE, KILOGRAM, METER, LITRE, HOUR
	 */
	public function getUnit()
	{
		return $this->values['unit'];
	}

	/**
	 * @param string $unit
	 * @return $this
	 */
	public function setUnit($unit)
	{
		$this->values['unit'] = $unit;
		return $this;
	}
}
