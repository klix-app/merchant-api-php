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
		$this->assertCount(1, $order->getOrderLines());
		$this->assertEquals('PHILIPS matu fēns XR3857', $order->getOrderLines()[0]->getLabel());
		$this->assertEquals('EUR', $order->getOrderLines()[0]->getCurrency());
		$this->assertEquals(32, $order->getOrderLines()[0]->getAmount());
		$this->assertEquals(0, $order->getOrderLines()[0]->getTaxAmount());
		$this->assertEquals(32, $order->getOrderLines()[0]->getTotalAmount());
		$this->assertEquals(0, $order->getOrderLines()[0]->getTaxRate());
		$this->assertEquals('PENDING', $order->getStatus());
		$this->assertEquals('EUR', $order->getPurchaseCurrency());
		$this->assertNotNull($order->getTotal());
		$this->assertEquals('EUR', $order->getTotal()->getCurrency());
		$this->assertEquals(26, $order->getTotal()->getAmount());
		$this->assertEquals(6, $order->getTotal()->getTaxAmount());
		$this->assertEquals(32, $order->getTotal()->getTotalAmount());
		$this->assertNotNull($order->getMerchantUrls());
		$this->assertEquals('www.demo-shop.lv/terms-and-conditions', $order->getMerchantUrls()->getTerms());
		$this->assertEquals('www.demo-shop.lv/api/orders', $order->getMerchantUrls()->getPlaceOrder());
		$this->assertEquals('www.demo-shop.lv/api/orders/verifications', $order->getMerchantUrls()->getVerification());
		$this->assertEquals('www.demo-shop.lv/api/orders/confirmations', $order->getMerchantUrls()->getConfirmation());

		$uri = new Uri("https://api-dev.cpay.lv/merchant/public/f6cef80b-92a4-4bc2-b611-7dc597f9ba60/orders/$orderId");
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

		$uri = new Uri("https://api-dev.cpay.lv/merchant/public/f6cef80b-92a4-4bc2-b611-7dc597f9ba60/orders/$orderId/verify");
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

		$uri = new Uri("https://api-dev.cpay.lv/merchant/public/f6cef80b-92a4-4bc2-b611-7dc597f9ba60/orders/$orderId/reject");
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
