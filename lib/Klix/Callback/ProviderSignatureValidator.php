<?php


namespace Klix\Callback;


use Klix\KlixConfiguration;

class ProviderSignatureValidator
{

	/**
	 * @var KlixConfiguration
	 */
	protected $apiConfiguration;

	/**
	 * @param KlixConfiguration $apiConfiguration
	 */
	public function __construct(KlixConfiguration $apiConfiguration)
	{
		$this->apiConfiguration = $apiConfiguration;
	}

	/**
	 * @param string $payload request body
	 * @param string $signature signature header value
	 * @return bool true if signature is valid
	 */
	public function isValid($payload, $signature)
	{
		return openssl_verify($payload, base64_decode($signature), $this->apiConfiguration->getProviderPublicKey(), OPENSSL_ALGO_SHA256) == 1;
	}
}
