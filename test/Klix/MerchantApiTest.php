<?php

namespace Klix;

use GuzzleHttp\Psr7\Uri;
use Klix\Api\ApiClient;
use Klix\Api\MerchantApi;
use Klix\Api\OrderRefund;
use Klix\Api\OrderRefundRequest;
use Klix\Api\OrderRejection;
use Klix\Api\RefundReason;

class MerchantApiTest extends BaseApiClientTest
{

	public function testOrderRefund()
	{
		$orderId = '9482996d-d3b2-4518-84aa-d6649bad6e99';
		$merchantId = $this->apiConfiguration->getMerchantId();
		$this->orderRefundReturnsEffectiveAmount();
		$apiClient = $this->createApiClient();
		$merchantApi = $this->createMerchantApi($apiClient);
		$orderRefund = new OrderRefund();
		$orderRefund->setAmount(10.00)
					->setReason(RefundReason::OTHER_REFUND)
					->setNote("Actual weight differs from ordered");
		$request = new OrderRefundRequest($orderId, $orderRefund);

		$orderRefundResponse = $merchantApi->refundOrder($request);

		$this->assertEquals(10.00, $orderRefundResponse->getTotalRefundedAmount());
		$this->assertEquals(110.00, $orderRefundResponse->getOrderEffectiveAmount());
		$uri = new Uri("https://api.stage.klix.app/v2/merchants/$merchantId/orders/$orderId/refunds");
		$this->requestMatched([
			RequestMatchers::httpMethodIs('POST'),
			RequestMatchers::requestUriIs($uri),
			RequestMatchers::requestBodyMatches($this->getTestResourceFileContents('refund-order-request.json')),
			RequestMatchers::containsHeader('digest', 'SHA-256=T1tfEOr6+zk0tOzCIjaFSS/dd2tWDYrtNWA5gP5ivoQ='),
			RequestMatchers::signatureIsValid($apiClient),
		]);
	}

	protected function orderRefundReturnsEffectiveAmount() {
		$responseBody = $this->getTestResourceFileContents('refund-order-response.json');
		$this->providerRespondsWith(200, $responseBody);
	}

	/**
	 * @param ApiClient $apiClient
	 * @return MerchantApi
	 */
	protected function createMerchantApi(ApiClient $apiClient)
	{
		return new MerchantApi($apiClient, $this->apiConfiguration);
	}
}
