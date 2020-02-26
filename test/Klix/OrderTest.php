<?php

namespace Klix;


use Klix\Widget\Order;
use Klix\Widget\OrderConstraints;
use Klix\Widget\OrderItem;
use Klix\Widget\ShippingOption;
use PHPUnit_Framework_TestCase;

class OrderTest extends PHPUnit_Framework_TestCase
{

	public function testOrderSerialization()
	{
		$firstOrderItem = new OrderItem();
		$firstOrderItem->setAmount(22.99);
		$secondOrderItem = new OrderItem();
		$secondOrderItem->setAmount(1.05);
		$shippingOption = new ShippingOption();
		$shippingOption->setId("courier");
		$shippingOption->setAmount(3);
		$constraints = new OrderConstraints();
		$constraints->setBrand("Citadele");
		$order = Order::create()
			->setOrderId("36c420f4-5487-11ea-a2e3-2e728ce88125")
		    ->addItem($firstOrderItem)
			->addItem($secondOrderItem)
			->addShippingOption($shippingOption)
			->setConstraints($constraints);

		$serializedOrder = json_encode($order);
		$result = json_decode($serializedOrder);

		self::assertEquals("36c420f4-5487-11ea-a2e3-2e728ce88125", $result->orderId);
		self::assertCount(2, $result->items);
		self::assertEquals(22.99, $result->items[0]->amount);
		self::assertCount(1, $result->shippingOptions);
		self::assertEquals(3, $result->shippingOptions[0]->amount);
		self::assertEquals("Citadele", $result->constraints->brand);
	}
}
