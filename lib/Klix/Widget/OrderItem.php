<?php


namespace Klix\Widget;


class OrderItem extends JsonSerializableObject implements SignatureSource
{

	use SignatureSourceFieldFormatter;

	/**
	 * @var float
	 */
	protected $amount;

	/**
	 * @var string
	 */
	protected $currency;

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var float
	 */
	protected $count;

	/**
	 * @var string
	 */
	protected $unit;

	/**
	 * @var float
	 */
	protected $taxRate;

	/**
	 * @var string
	 */
	protected $orderItemId;

	/**
	 * @return OrderItem
	 */
	public static function create() {
		return new OrderItem();
	}

	/**
	 * @return string
	 */
	public function toSignatureSource()
	{
		return $this->amountToString($this->amount)
			. $this->nullToEmptyString($this->currency)
			. $this->nullToEmptyString($this->label)
			. $this->floatToString($this->count, 3)
			. $this->nullToEmptyString($this->unit)
			. $this->amountToString($this->taxRate)
			. $this->nullToEmptyString($this->orderItemId);
	}

	/**
	 * @return bool
	 */
	public function hasJsonConfigurationAttributes()
	{
		return $this->orderItemId != null;
	}

	/**
	 * @param float $amount
	 * @return $this
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @param string $currency
	 * @return $this
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @param string $label
	 * @return $this
	 */
	public function setLabel($label)
	{
		$this->label = $label;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @param float $count
	 * @return $this
	 */
	public function setCount($count)
	{
		$this->count = $count;
		return $this;
	}


	/**
	 * @return float
	 */
	public function getCount()
	{
		return $this->count;
	}

	/**
	 * @param string $unit
	 * @return $this
	 */
	public function setUnit($unit)
	{
		$this->unit = $unit;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUnit()
	{
		return $this->unit;
	}

	/**
	 * @param float $taxRate
	 * @return $this
	 */
	public function setTaxRate($taxRate)
	{
		$this->taxRate = $taxRate;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getTaxRate()
	{
		return $this->taxRate;
	}

	/**
	 * @param string $orderItemId
	 * @return $this
	 */
	public function setOrderItemId($orderItemId)
	{
		$this->orderItemId = $orderItemId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getOrderItemId()
	{
		return $this->orderItemId;
	}
}
