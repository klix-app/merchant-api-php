<?php

namespace Klix;

class KlixApi {
	
	protected $brandId;
	
	protected $apiKey;
	
	protected $base;
	
	protected $client;
	
	protected $mapper;

	public function __construct($brandId, $apiKey, $base = 'https://portal.klix.app/api/v1/', $config = []) {
		$this->brandId = $brandId;
		$this->apiKey = $apiKey;
		$this->base = $base;
		$this->mapper = new \JsonMapper();
		$this->mapper->bStrictNullTypes = false;
		
		$this->client = new \GuzzleHttp\Client(array_merge([
			'base_uri' => $this->base,
		], $config));
	}
	
	protected function request($method, $endpoint, $options = array()) {
		$headers = [];
		if ($this->apiKey) {
			$headers['Authorization'] = 'Bearer ' . $this->apiKey;
		}
		$response = $this->client->request($method, $endpoint, array_merge(array(
			'headers' => $headers
		), $options));
		$body = (string)$response->getBody()->getContents();
		return json_decode($body);
		
		return null;
	}
	
	/**
	 * 
	 * @param string $currency
	 * @return Model\PaymentMethods
	 */
	
	public function getPaymentMethods($currency = 'EUR') {
		return $this->mapper->map($this->request('GET', 'payment_methods/', [
			'query' => [
				'brand_id' => $this->brandId,
				'currency' => $currency
			]
		]), new Model\PaymentMethods());
	}
	
	/**
	 * 
	 * @param \Klix\Model\Purchase $purchase
	 * @return Model\Purchase
	 */
	
	public function createPurchase($purchase) {
		return $this->mapper->map($this->request('POST', 'purchases/', [
			'json' => $purchase
		]), new Model\Purchase());
	}
	
	/**
	 * 
	 * @param string $purchaseId
	 * @return Model\Purchase
	 */
	
	public function getPurchase($purchaseId) {
		return $this->mapper->map($this->request('GET', 'purchases/' . $purchaseId . '/'), new Model\Purchase());
	}
	
	/**
	 * 
	 * @param string $purchaseId
	 * @return Model\Purchase
	 */
	public function cancelPurchase($purchaseId) {
		return $this->mapper->map($this->request('POST', 'purchases/' . $purchaseId . '/cancel/'), new Model\Purchase());
	}
	
	/**
	 * 
	 * @param string $purchaseId
	 * @return Model\Purchase
	 */
	public function releasePurchase($purchaseId) {
		return $this->mapper->map($this->request('POST', 'purchases/' . $purchaseId . '/release/'), new Model\Purchase());
	}
	
	/**
	 * 
	 * @param string $purchaseId
	 * @param int $amount
	 * @return Model\Purchase
	 */
	public function capturePurchase($purchaseId, $amount = null) {
		$options = [];
		if ($amount !== null) {
			$options['json'] = [
				'amount' => $amount
			];
		}
		return $this->mapper->map($this->request('POST', 'purchases/' . $purchaseId . '/capture/', $options), new Model\Purchase());
	}
	
	/**
	 * 
	 * @param string $purchaseId
	 * @param string $token
	 * @return Model\Purchase
	 */
	public function chargePurchase($purchaseId, $token) {
		return $this->mapper->map($this->request('POST', 'purchases/' . $purchaseId . '/charge/', [
			'json' => [
				'recurring_token' => $token
			]
		]), new Model\Purchase());
	}
	
	/**
	 * 
	 * @param string $purchaseId
	 * @return Model\Purchase
	 */
	public function deleteRecurringToken($purchaseId) {
		return $this->mapper->map($this->request('POST', 'purchases/' . $purchaseId . '/delete_recurring_token/'), new Model\Purchase());
	}
	
	/**
	 * 
	 * @param string $purchaseId
	 * @param int $amount
	 * @return Model\Purchase
	 */
	public function refundPurchase($purchaseId, $amount = null) {
		$options = [];
		if ($amount !== null) {
			$options['json'] = [
				'amount' => $amount
			];
		}
		return $this->mapper->map($this->request('POST', 'purchases/' . $purchaseId . '/refund/', $options), new Model\Purchase());
	}
	
	/**
	 * 
	 * @param string $content
	 * @param string $signature
	 * @param string $publicKey
	 * @return bool
	 */
	public static function verify($content, $signature, $publicKey) {
		return 1 === openssl_verify(
			$content, 
			base64_decode($signature), 
			$publicKey,
			'sha256WithRSAEncryption'
		);
	}
	
}