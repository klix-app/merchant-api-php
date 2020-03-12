<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Klix\Widget\ShippingOption;

class ShippingOptions
{

	/**
	 * @var array
	 */
	protected $shippingOptions = array();

	public function __construct()
	{
		$this->shippingOptions["omniva"] = ShippingOption::create()
			->setId("omniva")
			->setTitle("Omniva")
			->setAmount(1.99)
			->setTaxRate(0.21)
			->setCurrency("EUR");
		$this->shippingOptions["courier"] = ShippingOption::create()
			->setId("courier")
			->setTitle("Courier")
			->setAmount(7.00)
			->setTaxRate(0.21)
			->setCurrency("EUR");
	}

	/**
	 * @return array
	 */
	function getShippingOptions() {
		return array_values($this->shippingOptions);
	}

	/**
	 * @param string $shippingOptionId
	 * @return ShippingOption
	 */
	function getShippingOption($shippingOptionId) {
		return $this->shippingOptions[$shippingOptionId];
	}
}
