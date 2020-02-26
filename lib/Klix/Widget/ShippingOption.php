<?php


namespace Klix\Widget;


class ShippingOption extends JsonSerializableObject implements SignatureSource
{

	use SignatureSourceFieldFormatter;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var float
	 */
	protected $amount;

	/**
	 * @var string
	 */
	protected $currency;

	/**
	 * @var float
	 */
	protected $taxRate;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var boolean
	 */
	protected $excludeFromOrderIfFree;

	/**
	 * @return ShippingOption
	 */
	public static function create() {
		return new ShippingOption();
	}

	/**
	 * @return string
	 */
	public function toSignatureSource()
	{
		return $this->nullToEmptyString($this->id)
			. $this->amountToString($this->amount)
			. $this->nullToEmptyString($this->currency);
	}

	/**
	 * @param string $id
	 * @return $this
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
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
	 * @param string $currency
	 * @return $this
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;
		return $this;
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
	 * @param string $title
	 * @return $this
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @param bool $excludeFromOrderIfFree
	 * @return $this
	 */
	public function setExcludeFromOrderIfFree($excludeFromOrderIfFree)
	{
		$this->excludeFromOrderIfFree = $excludeFromOrderIfFree;
		return $this;
	}
}
