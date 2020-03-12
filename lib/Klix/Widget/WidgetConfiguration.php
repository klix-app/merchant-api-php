<?php


namespace Klix\Widget;


class WidgetConfiguration implements SignatureSource
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
	public function isHtmlAttributeConfiguration() {
		return !($this->order->hasConstraints() ||
			$this->order->hasShippingOptions() ||
			$this->order->getOrderItemCount() > 1 ||
			($this->order->getOrderItemCount() == 1 && $this->order->getOrderItem(0)->hasJsonConfigurationAttributes()));
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
