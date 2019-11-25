<?php

namespace Klix;

use GuzzleHttp\Psr7\Uri;
use Klix\Merchant\MerchantApi;
use Klix\Merchant\OrderRejection;

class MerchantApiTest extends BaseApiClientTest
{

	public function testOrderRetrieval()
	{
		$orderId = '9482996d-d3b2-4518-84aa-d6649bad6e99';
		$this->orderRetrievalReturnsOrderData();
		$merchantApi = $this->createMerchantApi();

		$order = $merchantApi->getOrder($orderId);

		$this->assertEquals($orderId, $order->getId());
		$this->assertEquals('PENDING', $order->getStatus())
		;
		$this->assertEquals('John', $order->getCustomer()->getFirstName());
		$this->assertEquals('Doe', $order->getCustomer()->getLastName());
		$this->assertEquals('john.doe@xyz.lv', $order->getCustomer()->getEmail());
		$this->assertEquals('37120000000', $order->getCustomer()->getPhoneNumber());

		$this->assertEquals('XYZ', $order->getCompany()->getName());
		$this->assertEquals('Republikas laukums 2a', $order->getCompany()->getAddress());
		$this->assertEquals('01234567890', $order->getCompany()->getRegistrationNumber());
		$this->assertEquals('LV01234567890', $order->getCompany()->getVatNumber());

		$this->assertEquals('362', $order->getOrderId());
		$this->assertEquals(18.22, $order->getTaxAmount());
		$this->assertEquals(105, $order->getTotalAmount());

		$this->assertCount(2, $order->getItems());
		$this->assertEquals(86.78, $order->getItems()[0]->getAmount());
		$this->assertEquals('Elektriskais zāģis Stiga SE 180 Q', $order->getItems()[0]->getLabel());
		$this->assertEquals(18.2238, $order->getItems()[0]->getTaxAmount());
		$this->assertEquals(105.0038, $order->getItems()[0]->getTotalAmount());
		$this->assertEquals(0.21, $order->getItems()[0]->getTaxRate());
		$this->assertEquals('STIGASE180Q', $order->getItems()[0]->getOrderItemId());
		$this->assertEquals(1, $order->getItems()[0]->getQuantity());
		$this->assertEquals('PIECE', $order->getItems()[0]->getUnit());
		$this->assertEquals('PHYSICAL_GOODS', $order->getItems()[0]->getType());
		$this->assertEquals(0, $order->getItems()[1]->getAmount());
		$this->assertEquals('Piegāde', $order->getItems()[1]->getLabel());
		$this->assertEquals(0, $order->getItems()[1]->getTaxAmount());
		$this->assertEquals(0, $order->getItems()[1]->getTotalAmount());
		$this->assertEquals(0.21, $order->getItems()[1]->getTaxRate());
		$this->assertEquals('DELIVERY', $order->getItems()[1]->getOrderItemId());
		$this->assertEquals(1, $order->getItems()[1]->getQuantity());
		$this->assertEquals('PIECE', $order->getItems()[1]->getUnit());
		$this->assertEquals('UNKNOWN', $order->getItems()[1]->getType());

		$this->assertEquals('EUR', $order->getCurrency());

		$this->assertNotNull($order->getMerchantUrls());
		$this->assertEquals('www.demo-shop.lv/terms-and-conditions', $order->getMerchantUrls()->getTerms());
		$this->assertEquals('www.demo-shop.lv/api/orders', $order->getMerchantUrls()->getPlaceOrder());
		$this->assertEquals('www.demo-shop.lv/api/orders/verifications', $order->getMerchantUrls()->getVerification());
		$this->assertEquals('www.demo-shop.lv/api/orders/confirmations', $order->getMerchantUrls()->getConfirmation());

		$this->assertEquals('PICKUP_POINT', $order->getShipping()->getType());
		$this->assertEquals('2019-09-15', $order->getShipping()->getDate());
		$this->assertNotNull($order->getShipping()->getAddress());
		$this->assertEquals('Latvia', $order->getShipping()->getAddress()->getCountry());
		$this->assertEquals('Rīga', $order->getShipping()->getAddress()->getCity());
		$this->assertEquals('Valdemāra iela 112', $order->getShipping()->getAddress()->getStreet());
		$this->assertEquals('LV-1013', $order->getShipping()->getAddress()->getPostalCode());

		$this->assertNotNull($order->getShipping()->getMethod());
		$this->assertEquals('DPDPICKUP', $order->getShipping()->getMethod()->getId());
		$this->assertEquals('DPD Pickup', $order->getShipping()->getMethod()->getName());

		$this->assertEquals('37120000000', $order->getShipping()->getContactPhone());

		$this->assertNotNull($order->getShipping()->getPickupPoint());
		$this->assertEquals('Paku Skapis Rimi Valdemārs', $order->getShipping()->getPickupPoint()->getName());
		$this->assertEquals('LV90007', $order->getShipping()->getPickupPoint()->getExternalId());
		$this->assertEquals('', $order->getShipping()->getPickupPoint()->getComments());
		$this->assertEquals('I-VII 00:00-24:00', $order->getShipping()->getPickupPoint()->getServiceHours());

		$uri = new Uri("https://api.stage.klix.app/merchants/f6cef80b-92a4-4bc2-b611-7dc597f9ba60/orders/$orderId");
		$this->requestMatched([
			RequestMatchers::httpMethodIs('GET'),
			RequestMatchers::requestUriIs($uri),
			RequestMatchers::containsHeaders($this->apiConfiguration->getApiKey())
		]);
	}

	public function testOrderVerification()
	{
		$orderId = '9482996d-d3b2-4518-84aa-d6649bad6e99';
		$this->orderRetrievalReturnsOrderData();
		$this->providerRespondsWith(200);
		$merchantApi = $this->createMerchantApi();
		$order = $merchantApi->getOrder($orderId);

		$merchantApi->verifyOrder($order);

		$uri = new Uri("https://api.stage.klix.app/merchants/f6cef80b-92a4-4bc2-b611-7dc597f9ba60/orders/$orderId");
		$this->requestMatched([
			RequestMatchers::httpMethodIs('PUT'),
			RequestMatchers::requestUriIs($uri),
			RequestMatchers::containsHeaders($this->apiConfiguration->getApiKey()),
			RequestMatchers::requestBodyMatches($this->getTestResourceFileContents('signed-jwt/SignedOrderVerificationRequest.txt'))
		]);
	}

	public function testOrderRejection()
	{
		$orderId = '9482996d-d3b2-4518-84aa-d6649bad6e99';
		$orderRejection = new OrderRejection('OUT_OF_STOCK');
		$this->providerRespondsWith(200);
		$merchantApi = $this->createMerchantApi();

		$merchantApi->rejectOrder($orderId, $orderRejection);

		$uri = new Uri("https://api.stage.klix.app/merchants/f6cef80b-92a4-4bc2-b611-7dc597f9ba60/orders/$orderId");
		$this->requestMatched([
			RequestMatchers::httpMethodIs('DELETE'),
			RequestMatchers::requestUriIs($uri),
			RequestMatchers::containsHeaders($this->apiConfiguration->getApiKey()),
			RequestMatchers::requestBodyMatches($this->getTestResourceFileContents('signed-jwt/SignedOrderRejectionRequest.txt'))
		]);
	}

	protected function orderRetrievalReturnsOrderData() {
		$responseBody = $this->getTestResourceFileContents('responses/get-order.json');
		$this->providerRespondsWith(200, $responseBody);
	}

	protected function createMerchantApi()
	{
		$apiClient = $this->createApiClient();
		return new MerchantApi($apiClient);
	}
}
