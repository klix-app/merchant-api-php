<?php

namespace Klix;


use Klix\Widget\CheckoutWidget;
use Klix\Widget\Order;
use Klix\Widget\OrderItem;
use Klix\Widget\WidgetConfiguration;

class CheckoutWidgetTest extends AbstractWidgetConfigurationTest
{

	public function testHtmlAttributesWidgetHtmlGeneration() {
		$signature = "some-signature";
		$widgetConfiguration = $this->getSingleOrderItemConfiguration();
		$checkoutWidget = new CheckoutWidget($widgetConfiguration, $signature);

		$htmlRepresentation = $checkoutWidget->getHtmlRepresentation();

		$xml = simplexml_load_string($htmlRepresentation);
		self::assertEquals("klix-checkout", $xml->getName());
		self::assertEquals($widgetConfiguration->getWidgetId(), $xml->attributes()["widget-id"]);
		self::assertEquals($widgetConfiguration->getLanguage(), $xml->attributes()["language"]);
		self::assertEquals($widgetConfiguration->getCertificateName(), $xml->attributes()["certificate-name"]);
		self::assertEquals($widgetConfiguration->getBackToMerchantUrl(), $xml->attributes()["back-to-merchant-url"]);
		self::assertEquals($widgetConfiguration->getSuccessfulPurchaseRedirectUrl(), $xml->attributes()["success-redirect-url"]);
		self::assertEquals($signature, $xml->attributes()["signature"]);
		self::assertNull($xml->attributes()["order"]);
		self::assertEquals($widgetConfiguration->getOrder()->getOrderId(), $xml->attributes()["order-id"]);
		self::assertEquals($widgetConfiguration->getOrder()->getFirstItem()->getAmount(), (float) $xml->attributes()["amount"]);
		self::assertEquals($widgetConfiguration->getOrder()->getFirstItem()->getCurrency(), $xml->attributes()["currency"]);
		self::assertEquals($widgetConfiguration->getOrder()->getFirstItem()->getCount(), (integer) $xml->attributes()["count"]);
		self::assertEquals($widgetConfiguration->getOrder()->getFirstItem()->getUnit(), $xml->attributes()["unit"]);
		self::assertEquals($widgetConfiguration->getOrder()->getFirstItem()->getLabel(), $xml->attributes()["label"]);
		self::assertEquals($widgetConfiguration->getOrder()->getFirstItem()->getTaxRate(), (float) $xml->attributes()["tax-rate"]);
	}

	public function testJsonConfigWidgetHtmlGeneration() {
		$signature = "some-signature";
		$widgetConfiguration = $this->getWidgetConfiguration();
		$checkoutWidget = new CheckoutWidget($widgetConfiguration, $signature);

		$htmlRepresentation = $checkoutWidget->getHtmlRepresentation();

		$xml = simplexml_load_string($htmlRepresentation);
		self::assertEquals("klix-checkout", $xml->getName());
		self::assertEquals($widgetConfiguration->getWidgetId(), $xml->attributes()["widget-id"]);
		self::assertEquals($widgetConfiguration->getLanguage(), $xml->attributes()["language"]);
		self::assertEquals($widgetConfiguration->getCertificateName(), $xml->attributes()["certificate-name"]);
		self::assertEquals($widgetConfiguration->getBackToMerchantUrl(), $xml->attributes()["back-to-merchant-url"]);
		self::assertEquals($signature, $xml->attributes()["signature"]);
		self::assertEquals($widgetConfiguration->getOrderJson(), $xml->attributes()["order"]);
		self::assertNull($xml->attributes()["amount"]);
	}

	public function testJsonConfigWidgetHtmlGenerationInCaseOfSingleOrderLineWithId() {
		$signature = "some-signature";
		$widgetConfiguration = $this->getSingleOrderItemConfiguration();
		$widgetConfiguration->getOrder()->getFirstItem()->setOrderItemId("ff713414-56f9-11ea-82b4-0242ac130003");
		$checkoutWidget = new CheckoutWidget($widgetConfiguration, $signature);

		$htmlRepresentation = $checkoutWidget->getHtmlRepresentation();

		$xml = simplexml_load_string($htmlRepresentation);
		self::assertEquals("klix-checkout", $xml->getName());
		self::assertEquals($widgetConfiguration->getWidgetId(), $xml->attributes()["widget-id"]);
		self::assertEquals($widgetConfiguration->getLanguage(), $xml->attributes()["language"]);
		self::assertEquals($widgetConfiguration->getCertificateName(), $xml->attributes()["certificate-name"]);
		self::assertEquals($widgetConfiguration->getBackToMerchantUrl(), $xml->attributes()["back-to-merchant-url"]);
		self::assertEquals($widgetConfiguration->getSuccessfulPurchaseRedirectUrl(), $xml->attributes()["success-redirect-url"]);
		self::assertEquals($signature, $xml->attributes()["signature"]);
		self::assertEquals($widgetConfiguration->getOrderJson(), $xml->attributes()["order"]);
		self::assertNull($xml->attributes()["amount"]);
	}

	/**
	 * @return WidgetConfiguration
	 */
	protected function getSingleOrderItemConfiguration() {
		$firstOrderItem = OrderItem::create()
			->setAmount(122.99)
			->setCount(2)
			->setCurrency("EUR")
			->setLabel("Vacuum cleaner TC31")
			->setTaxRate(0.21)
			->setUnit("PIECE");
		$order = Order::create()
			->setOrderId("36c420f4-5487-11ea-a2e3-2e728ce88125")
			->addItem($firstOrderItem);
		return WidgetConfiguration::create()
			->setWidgetId("d700a786-56da-11ea-8e2d-0242ac130003")
			->setLanguage("lv")
			->setCertificateName("6af6c4fc-56db-11ea-8e2d-0242ac130003")
			->setSuccessfulPurchaseRedirectUrl("https://example.com/purchase-completed")
			->setBackToMerchantUrl("https://example.com/payment-method-selection")
			->setOrder($order);
	}
}
