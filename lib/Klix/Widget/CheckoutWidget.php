<?php


namespace Klix\Widget;


class CheckoutWidget
{

	/**
	 * @var WidgetConfiguration
	 */
	protected $widgetConfiguration;

	/**
	 * @var String
	 */
	protected $signature;

	/**
	 * @param WidgetConfiguration $widgetConfiguration
	 * @param string $signature
	 */
	public function __construct($widgetConfiguration, $signature)
	{
		$this->widgetConfiguration = $widgetConfiguration;
		$this->signature = $signature;
	}

	/**
	 * @return string
	 */
	public function getHtmlRepresentation() {
		$representation = '<klix-checkout'
			. $this->getHtmlAttribute('widget-id', $this->widgetConfiguration->getWidgetId())
			. $this->getHtmlAttribute('language', $this->widgetConfiguration->getLanguage())
			. $this->getHtmlAttribute('certificate-name', $this->widgetConfiguration->getCertificateName())
			. $this->getHtmlAttribute('signature', $this->signature);
		if ($this->widgetConfiguration->isHtmlAttributeConfiguration()) {
			$representation .= $this->getHtmlAttribute('order-id', $this->widgetConfiguration->getOrder()->getOrderId());
			$orderItem = $this->widgetConfiguration->getOrder()->getFirstItem();
			$representation .= $this->getHtmlAttribute('amount', $orderItem->getAmount());
			$representation .= $this->getHtmlAttribute('currency', $orderItem->getCurrency());
			$representation .= $this->getHtmlAttribute('count', $orderItem->getCount());
			$representation .= $this->getHtmlAttribute('unit', $orderItem->getUnit());
			$representation .= $this->getHtmlAttribute('label', $orderItem->getLabel());
			$representation .= $this->getHtmlAttribute('tax-rate', $orderItem->getTaxRate());
		} else {
			$representation .= $this->getHtmlAttribute('order', $this->widgetConfiguration->getOrderJson());
		}
		$representation .= '></klix-checkout>';
		return $representation;
	}

	/**
	 * @param string $attributeName
	 * @param string $attributeValue
	 * @return string
	 */
	private function getHtmlAttribute($attributeName, $attributeValue) {
		if ($attributeValue !== null) {
			return ' ' . $attributeName . '="' . htmlspecialchars($attributeValue) . '"';
		}

		return '';
	}
}
