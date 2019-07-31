<?php

namespace Klix\Merchant;

class MerchantOrder extends Model
{
	/**
	 * @return Customer
	 */
	public function getCustomer()
	{
		return new Customer($this->values['customer']);
	}

	/**
	 * @param Customer $customer
	 * @return $this
	 */
	public function setCustomer($customer)
	{
		$this->values['customer'] = $customer->values;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->values['id'];
	}

	/**
	 * @param string $id
	 * @return $this
	 */
	public function setId($id)
	{
		$this->values['id'] = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLocale()
	{
		return $this->values['locale'];
	}

	/**
	 * @param string $locale
	 * @return $this
	 */
	public function setLocale($locale)
	{
		$this->values['locale'] = $locale;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMerchantReference()
	{
		return $this->values['merchantReference'];
	}

	/**
	 * @param string $merchantReference
	 * @return $this
	 */
	public function setMerchantReference($merchantReference)
	{
		$this->values['merchantReference'] = $merchantReference;
		return $this;
	}

	/**
	 * @return MerchantUrls
	 */
	public function getMerchantUrls()
	{
		return new MerchantUrls($this->values['merchantUrls']);
	}

	/**
	 * @param MerchantUrls $merchantUrls
	 * @return $this
	 */
	public function setMerchantUrls($merchantUrls)
	{
		$this->values['merchantUrls'] = $merchantUrls->values;
		return $this;
	}

	/**
	 * @return OrderItem[]
	 */
	public function getOrderLines()
	{
		return array_map(function($orderLineValues) {
			return new OrderItem($orderLineValues);
		}, (array) $this->values['orderLines']);
	}

	/**
	 * @param OrderItem[] $orderLines
	 * @return $this
	 */
	public function setOrderLines($orderLines)
	{
		$this->values['orderLines'] = array_map(function($orderItem) {
			return $orderItem->values;
		}, $orderLines);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPurchaseCountry()
	{
		return $this->values['purchaseCountry'];
	}

	/**
	 * @param string $purchaseCountry
	 * @return $this
	 */
	public function setPurchaseCountry($purchaseCountry)
	{
		$this->values['purchaseCountry'] = $purchaseCountry;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPurchaseCurrency()
	{
		return $this->values['purchaseCurrency'];
	}

	/**
	 * @param string $purchaseCurrency
	 * @return $this
	 */
	public function setPurchaseCurrency($purchaseCurrency)
	{
		$this->values['purchaseCurrency'] = $purchaseCurrency;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->values['status'];
	}

	/**
	 * @param string $status
	 * @return $this
	 */
	public function setStatus($status)
	{
		$this->values['status'] = $status;
		return $this;
	}

	/**
	 * @return OrderTotal
	 */
	public function getTotal()
	{
		return new OrderTotal($this->values['total']);
	}

	/**
	 * @param OrderTotal $total
	 * @return $this
	 */
	public function setTotal($total)
	{
		$this->values['total'] = $total->values;
		return $this;
	}
}
