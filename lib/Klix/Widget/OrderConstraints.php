<?php


namespace Klix\Widget;


class OrderConstraints extends JsonSerializableObject implements SignatureSource
{

	use SignatureSourceFieldFormatter;

	protected $paymentScheme;

	protected $issuer;

	protected $brand;

	/**
	 * @return string
	 */
	public function toSignatureSource()
	{
		return $this->nullToEmptyString($this->paymentScheme)
			. $this->nullToEmptyString($this->issuer)
			. $this->nullToEmptyString($this->brand);
	}

	/**
	 * @param mixed $paymentScheme
	 * @return $this
	 */
	public function setPaymentScheme($paymentScheme)
	{
		$this->paymentScheme = $paymentScheme;
		return $this;
	}

	/**
	 * @param mixed $issuer
	 * @return $this
	 */
	public function setIssuer($issuer)
	{
		$this->issuer = $issuer;
		return $this;
	}

	/**
	 * @param mixed $brand
	 * @return $this
	 */
	public function setBrand($brand)
	{
		$this->brand = $brand;
		return $this;
	}

}
