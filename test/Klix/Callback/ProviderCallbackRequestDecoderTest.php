<?php

namespace Klix\Callback;


use Klix\AbstractApiConfigurationTest;

class ProviderCallbackRequestDecoderTest extends AbstractApiConfigurationTest
{

	function testRequestDecoding()
	{
		$payload = $this->getTestResourceFileContents('purchase-notification.json');
		$signature = 'MKqXr7siOkC6TYENeHUcy5ofFDiWpqMt+ow5iWJqnIYWU71W50fZFHfy3BVrehEGCvf+TufZK6DPymdM1e2G0w==';
		$validator = new ProviderSignatureValidator($this->getApiConfiguration());
		$decoder = new ProviderCallbackRequestDecoder($validator);

		$merchantOrder = $decoder->decodePurchaseFinalizedRequest($payload, $signature);

		self::assertEquals('d72096a0-58f2-46f0-9a4c-6d2271784530', $merchantOrder->getId());
		self::assertEquals('PAID', $merchantOrder->getStatus());
		self::assertNotNull($merchantOrder->getCustomer());
		self::assertEquals('Doe', $merchantOrder->getCustomer()->getLastName());
		self::assertNotNull($merchantOrder->getPayment());
		self::assertEquals('731589767', $merchantOrder->getPayment()->getAccountStatementReference());
		self::assertEquals(18.53, $merchantOrder->getTaxAmount());
		self::assertEquals(108.78, $merchantOrder->getTotalAmount());
		self::assertEquals(3, sizeof($merchantOrder->getItems()));
		self::assertNotNull($merchantOrder->getShipping());
		self::assertEquals('PICKUP_POINT', $merchantOrder->getShipping()->getType());
		self::assertEquals('omniva', $merchantOrder->getShipping()->getMethod()->getId());
		self::assertNotNull($merchantOrder->getShipping()->getPickupPoint());
	}
}
