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
    public function getLabel()
    {
        return $this->values['label'];
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->values['label'] = $label;
        return $this;
    }

	/**
	 * @return float
	 */
	public function getTaxAmount()
	{
		return $this->values['tax_amount'];
	}

	/**
	 * @param float $taxAmount
	 * @return $this
	 */
	public function setTaxAmount($taxAmount)
	{
		$this->values['tax_amount'] = $taxAmount;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getTotalAmount()
	{
		return $this->values['total_amount'];
	}

	/**
	 * @param float $totalAmount
	 * @return $this
	 */
	public function setTotalAmount($totalAmount)
	{
		$this->values['total_amount'] = $totalAmount;
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
	 * @return string
	 */
	public function getOrderItemId()
	{
		return $this->values['order_item_id'];
	}

	/**
	 * @param string $orderItemId
	 * @return $this
	 */
	public function setOrderItemId($orderItemId)
	{
		$this->values['order_item_id'] = $orderItemId;
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
}
