<?php


namespace Klix\Widget;


class CheckoutWidgetFactory
{

	/**
	 * @var WidgetConfigurationSigner
	 */
	protected $widgetConfigurationSigner;

	/**
	 * @param WidgetConfigurationSigner $widgetConfigurationSigner
	 */
	public function __construct(WidgetConfigurationSigner $widgetConfigurationSigner)
	{
		$this->widgetConfigurationSigner = $widgetConfigurationSigner;
	}

	/**
	 * @param WidgetConfiguration
	 * @return CheckoutWidget
	 */
	public function create($widgetConfiguration) {
		$signature = $this->widgetConfigurationSigner->getSignature($widgetConfiguration);
		return new CheckoutWidget($widgetConfiguration, $signature);
	}
}
