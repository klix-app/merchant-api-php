<?php

use Klix\Model\Product;

class ProductSerializationTest extends TestCase
{
	public function shouldNotOmitIntZeroValueFromJsonOutput() {
		$product = new Product();
		$product->name = "Recurring registration";
		$product->price = 0;

		$encodedProduct = json_encode($product);
		$this->assertThat($encodedProduct, $this->stringContains('Recurring registration'));
		$this->assertThat($encodedProduct, $this->stringContains('\"price\":0'));
		$this->assertThat($encodedProduct, $this->logicalNot($this->stringContains('quantity')));
	}
}
