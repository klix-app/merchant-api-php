<?php

use Klix\Model\PaymentMethodDetails;
use Klix\Model\PisBulkPurchase;
use Klix\Model\Product;
use Klix\Model\PurchaseDetails;

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

	public function shouldAddCreditorNameAndIbanToJsonOutput() {
		$pisBulkPurchase = new PisBulkPurchase();
		$pisBulkPurchase->creditor_name = "John Doe";
		$pisBulkPurchase->creditor_iban = "LV00JOHN0000000000000";
		$paymentMethodDetails = new PaymentMethodDetails();
		$paymentMethodDetails->pis_bulk_purchase = array($pisBulkPurchase);
		$purchaseDetails = new PurchaseDetails();
		$purchaseDetails->payment_method_details = $paymentMethodDetails;

		$encodedPurchaseDetails = json_encode($purchaseDetails);
		$this->assertThat($encodedPurchaseDetails, $this->stringContains('\"creditor_name\":\"John Doe\"'));
		$this->assertThat($encodedPurchaseDetails, $this->stringContains('\"creditor_iban\":\"LV00JOHN0000000000000\"'));
	}
}
