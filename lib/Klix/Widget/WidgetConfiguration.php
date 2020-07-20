<?php


namespace Klix\Widget;


class WidgetConfiguration
{

	use SignatureSourceFieldFormatter;

	/**
	 * @var string
	 */
	protected $widgetId;

	/**
	 * @var string
	 */
	protected $language;

	/**
	 * @var string
	 */
	protected $certificateName;

	/**
	 * @var string
	 */
	protected $successfulPurchaseRedirectUrl;

	/**
	 * @var string
	 */
	protected $backToMerchantUrl;

	/**
	 * @var Order
	 */
	protected $order;

	/**
	 * @return WidgetConfiguration
	 */
	public static function create() {
		return new WidgetConfiguration();
	}

	/**
	 * @return string
	 */
	public function toSignatureSource()
	{
		return $this->widgetId
			. $this->language
			. $this->nullToEmptyString($this->certificateName)
			. $this->nullToEmptyString($this->successfulPurchaseRedirectUrl)
			. $this->nullToEmptyString($this->backToMerchantUrl)
			. $this->order->toSignatureSource();
	}

	/**
	 * @return string
	 */
	public function getOrderJson() {
		return json_encode($this->order);
	}

	/**
	 * @return bool
	 */
	public function isJsonConfiguration() {
		return $this->order->isJsonConfiguration();
	}

	/**
	 * @param string $widgetId
	 * @return $this
	 */
	public function setWidgetId($widgetId)
	{
		$this->widgetId = $widgetId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getWidgetId()
	{
		return $this->widgetId;
	}

	/**
	 * @param string $language
	 * @return $this
	 */
	public function setLanguage($language)
	{
		$this->language = $language;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * @param string $certificateName
	 * @return $this
	 */
	public function setCertificateName($certificateName)
	{
		$this->certificateName = $certificateName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCertificateName()
	{
		return $this->certificateName;
	}

	/**
	 * @param string $successfulPurchaseRedirectUrl
	 * @return $this
	 */
	public function setSuccessfulPurchaseRedirectUrl($successfulPurchaseRedirectUrl)
	{
		$this->successfulPurchaseRedirectUrl = $successfulPurchaseRedirectUrl;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSuccessfulPurchaseRedirectUrl()
	{
		return $this->successfulPurchaseRedirectUrl;
	}

	/**
	 * @param string $backToMerchantUrl
	 * @return $this
	 */
	public function setBackToMerchantUrl($backToMerchantUrl)
	{
		$this->backToMerchantUrl = $backToMerchantUrl;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBackToMerchantUrl()
	{
		return $this->backToMerchantUrl;
	}

	/**
	 * @param Order $order
	 * @return $this
	 */
	public function setOrder($order)
	{
		$this->order = $order;
		return $this;
	}

	/**
	 * @return Order
	 */
	public function getOrder()
	{
		return $this->order;
	}
}
