<?php

namespace Klix\Api;

use Klix\ApiException;
use Klix\KlixConfiguration;
use Klix\Preconditions;

class MerchantApi
{
	/**
	 * @var ApiClient
	 */
	protected $apiClient;

	/**
	 * @var KlixConfiguration
	 */
	protected $klixConfiguration;

    /**
     * @param ApiClient $apiClient
	 * @param KlixConfiguration $klixConfiguration
     */
    public function __construct($apiClient, $klixConfiguration) {
        $this->apiClient = $apiClient;
        $this->klixConfiguration = $klixConfiguration;
    }

	/**
	 * @param $orderRefundRequest OrderRefundRequest
	 * @return OrderRefundResponse
	 * @throws ApiException
	 */
	public function refundOrder($orderRefundRequest)
	{
		Preconditions::checkNotNull($orderRefundRequest, "Order refund request not specified");
		$request = $this->apiClient->createRequest(
			'POST',
			'/v2/merchants/{merchantId}/orders/{orderId}/refunds',
			[
				'merchantId'=>$this->klixConfiguration->getMerchantId(),
				'orderId'=>$orderRefundRequest->getOrderId()
			],
			$orderRefundRequest->getOrderRefund()->getValues()
		);
		return $this->apiClient->makeHttpCall($request, '\Klix\Api\OrderRefundResponse');
	}
}
