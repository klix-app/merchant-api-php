<?php


namespace Klix;


use Klix\Widget\CheckoutWidgetFactory;
use Klix\Widget\WidgetConfigurationSigner;

class CheckoutWidgetE2ETest extends AbstractWidgetConfigurationTest
{

	public function testHtmlAttributesWidgetHtmlGeneration() {
		$apiConfiguration = $this->getApiConfiguration();
		$widgetConfigurationSigner = new WidgetConfigurationSigner($apiConfiguration);
		$checkoutWidgetFactory = new CheckoutWidgetFactory($widgetConfigurationSigner);
		$widgetConfiguration = $this->getWidgetConfiguration();

		$checkoutWidget = $checkoutWidgetFactory->create($widgetConfiguration);
		$htmlRepresentation = $checkoutWidget->getHtmlRepresentation();

		$xml = simplexml_load_string($htmlRepresentation);
		self::assertEquals("klix-checkout", $xml->getName());
		self::assertEquals($widgetConfiguration->getWidgetId(), $xml->attributes()["widget-id"]);
		self::assertNotNull($xml->attributes()["signature"]);
	}
}
