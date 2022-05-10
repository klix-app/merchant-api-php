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
	 * getPaymentMethods
	 *
	 * @param  mixed $currency Currency you'd use in your Purchase in ISO 4217 format, e.g. EUR.
	 * @param  mixed $country Country code in the ISO 3166-1 alpha-2 format (e.g. LV,LT,EE,RU). Optional.
	 * @param  mixed $language Country code in the ISO 3166-1 alpha-2 format (e.g. lv,lt,ee,ru). Optional.
	 * @param  mixed $recurring If provided in the format of recurring=true, will filter out the methods that don't support recurring charges (see POST /purchases/{id}/charge/).
	 * @param  mixed $skip_capture If provided in the format of skip_capture=true, will filter out the methods that don't support skip_capture functionality (see the description for Purchase.skip_capture field).
	 * @param  mixed $preauthorization If provided in the format of preauthorization=true, will filter out the methods that don't support preauthorization functionality (see the description for Purchase.skip_capture field).
	 * @return void
	 */
	public function getPaymentMethods($currency = 'EUR',$country='',$language='',$recurring='',$skip_capture='',$preauthorization='') {
		$query['query']['brand_id']=$this->brandId;
		$query['query']['currency']=$currency;

		if($country !=='' ) {
			$query['query']['country']=strtoupper($country);
		}
		if($language !=='' ) {
			$query['query']['language']=strtolower($language);
		}
		if($recurring !== '' ) {
			$query['query']['recurring']=$recurring;
		}
		if($skip_capture !== '' ) {
			$query['query']['skip_capture']=$skip_capture;
		}
		if($preauthorization !== '' ) {
			$query['query']['preauthorization']=$preauthorization;
		}
		return $this->mapper->map($this->request('GET', 'payment_methods/', $query), new Model\PaymentMethods());
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