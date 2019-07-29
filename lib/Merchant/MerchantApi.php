<?php

namespace Klix\Merchant;

use Klix\ApiClient;
use Klix\ApiException;
use Klix\Preconditions;

class MerchantApi
{
	/**
	 * @var ApiClient
	 */
	protected $apiClient;

    /**
     * @param ApiClient $apiClient
     */
    public function __construct($apiClient) {
        $this->apiClient = $apiClient;
    }

	/**
	 * @param $order_id
	 * @return MerchantOrder
	 * @throws ApiException
	 */
    public function getOrder($order_id)
    {
    	Preconditions::checkNotNull($order_id, "Order id not specified");
    	$request = $this->apiClient->createRequest(
    		'GET',
			'/merchant/public/{merchantId}/orders/{orderId}',
			['orderId'=>$order_id]
		);
		return $this->apiClient->makeHttpCall($request, '\Klix\Merchant\MerchantOrder');
    }


	/**
	 * @param $order_id string
	 * @param $body OrderRejection
	 * @throws ApiException
	 */
    public function rejectOrder($order_id, $body)
    {
		Preconditions::checkNotNull($order_id, "Order id not specified");
		Preconditions::checkNotNull($body, "Order rejection not specified");
		Preconditions::checkNotNull($body->getReasonCode(), "Order rejection reason not specified");
		$request = $this->apiClient->createRequest(
			'DELETE',
			'/merchant/public/{merchantId}/orders/{orderId}/reject',
			['orderId'=>$order_id],
			$body->getValues()
		);
		$this->apiClient->makeHttpCall($request);
    }

	/**
	 * @param $body MerchantOrder
	 * @throws ApiException
	 */
	public function verifyOrder($body)
	{
		Preconditions::checkNotNull($body, "Order not specified");
		$request = $this->apiClient->createRequest(
			'PUT',
			'/merchant/public/{merchantId}/orders/{orderId}/verify',
			['orderId'=>$body->getId()],
			$body->getValues()
		);
		$this->apiClient->makeHttpCall($request);
	}
}
