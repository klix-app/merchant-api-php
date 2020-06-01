<?php


namespace Klix;

use Klix\Widget\Order;
use Klix\Widget\OrderConstraints;
use Klix\Widget\OrderItem;
use Klix\Widget\ShippingOption;
use Klix\Widget\WidgetConfiguration;

abstract class AbstractWidgetConfigurationTest extends AbstractApiConfigurationTest
{

	/**
	 * @return WidgetConfiguration
	 */
	protected function getWidgetConfiguration() {
		$firstOrderItem = OrderItem::create()
			->setAmount(122.99)
			->setCount(2)
			->setCurrency("EUR")
			->setLabel("Vacuum cleaner TC31")
			->setOrderItemId("ff713414-56f9-11ea-82b4-0242ac130003")
			->setTaxRate(0.21)
			->setUnit("PIECE");
		$secondOrderItem = OrderItem::create()
			->setAmount(7.05)
			->setCurrency('EUR')
			->setLabel("Filter for TC31");
		$firstShippingOption = ShippingOption::create()
			->setId("courier")
			->setAmount(3);
		$secondShippingOption = ShippingOption::create()
			->setId("pickup")
			->setTitle("In store pickup")
			->setAmount(0)
			->setCurrency("EUR");
		$constraints = new OrderConstraints();
		$constraints->setBrand("Citadele");
		$order = Order::create()
			->setOrderId("36c420f4-5487-11ea-a2e3-2e728ce88125")
			->addItem($firstOrderItem)
			->addItem($secondOrderItem)
			->addShippingOption($firstShippingOption)
			->addShippingOption($secondShippingOption)
			->setConstraints($constraints);
		return WidgetConfiguration::create()
			->setWidgetId("d700a786-56da-11ea-8e2d-0242ac130003")
			->setLanguage("lv")
			->setBackToMerchantUrl("https://merchant.home.url.com")
			->setCertificateName("6af6c4fc-56db-11ea-8e2d-0242ac130003")
			->setOrder($order);
	}

}
