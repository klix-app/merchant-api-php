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

		$this->assertEquals('XYZ', $order->getCompany()->getName());
		$this->assertEquals('Republikas laukums 2a', $order->getCompany()->getAddress());
		$this->assertEquals('01234567890', $order->getCompany()->getRegistrationNumber());
		$this->assertEquals('LV01234567890', $order->getCompany()->getVatNumber());
		$this->assertEquals('John', $order->getCustomer()->getFirstName());
		$this->assertEquals('Doe', $order->getCustomer()->getLastName());
		$this->assertEquals('john.doe@xyz.lv', $order->getCustomer()->getEmail());
		$this->assertEquals('37120000000', $order->getCustomer()->getPhoneNumber());
		$this->assertEquals($orderId, $order->getId());
		$this->assertNotNull($order->getMerchantUrls());
		$this->assertEquals('www.demo-shop.lv/terms-and-conditions', $order->getMerchantUrls()->getTerms());
		$this->assertEquals('www.demo-shop.lv/api/orders', $order->getMerchantUrls()->getPlaceOrder());
		$this->assertEquals('www.demo-shop.lv/api/orders/verifications', $order->getMerchantUrls()->getVerification());
		$this->assertEquals('www.demo-shop.lv/api/orders/confirmations', $order->getMerchantUrls()->getConfirmation());
		$this->assertEquals(32, $order->getOrderAmount());
		$this->assertCount(1, $order->getOrderLines());
		$this->assertEquals('PHILIPS matu fēns XR3857', $order->getOrderLines()[0]->getName());
		$this->assertEquals(32, $order->getOrderLines()[0]->getAmount());
		$this->assertEquals(1, $order->getOrderLines()[0]->getQuantity());
		$this->assertEquals('PHILIPSXR3857', $order->getOrderLines()[0]->getReference());
		$this->assertEquals(0.21, $order->getOrderLines()[0]->getTaxRate());
		$this->assertEquals('PHYSICAL_GOODS', $order->getOrderLines()[0]->getType());
		$this->assertEquals('PIECE', $order->getOrderLines()[0]->getUnit());
		$this->assertEquals(6.72, $order->getOrderTaxAmount());
		$this->assertEquals('EUR', $order->getPurchaseCurrency());
		$this->assertNotNull($order->getShipment()->getAddress());
		$this->assertEquals('Rīga', $order->getShipment()->getAddress()->getCity());
		$this->assertEquals('Latvia', $order->getShipment()->getAddress()->getCountry());
		$this->assertEquals('LV-1013', $order->getShipment()->getAddress()->getPostalCode());
		$this->assertEquals('Valdemāra iela 112', $order->getShipment()->getAddress()->getStreet());
		$this->assertEquals('37120000000', $order->getShipment()->getContactPhone());
		$this->assertEquals('2019-09-15', $order->getShipment()->getDate());
		$this->assertEquals('PICKUP_POINT', $order->getShipment()->getType());
		$this->assertNotNull($order->getShipment()->getMethod());
		$this->assertEquals('DPDPICKUP', $order->getShipment()->getMethod()->getId());
		$this->assertEquals('DPD Pickup', $order->getShipment()->getMethod()->getName());
		$this->assertNotNull($order->getShipment()->getPickupPoint());
		$this->assertEquals('Paku Skapis Rimi Valdemārs', $order->getShipment()->getPickupPoint()->getName());
		$this->assertEquals('LV90007', $order->getShipment()->getPickupPoint()->getExternalId());
		$this->assertEquals('', $order->getShipment()->getPickupPoint()->getComments());
		$this->assertEquals('I-VII 00:00-24:00', $order->getShipment()->getPickupPoint()->getServiceHours());
		$this->assertEquals('PENDING', $order->getStatus());

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
