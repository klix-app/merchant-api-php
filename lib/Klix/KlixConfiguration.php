<?php

namespace Klix;

class KlixConfiguration
{
	const API_BASE_URL = "https://api.klix.app";

	const TEST_BASE_URL = "https://api.stage.klix.app";

	/**
	 * @var string
	 */
	protected $baseUri;

	/**
	 * @var string
	 */
	protected $merchantId;

	/**
	 * @var string merchant's private key id obtained in Klix merchant console
	 */
	protected $privateKeyId;

	/**
	 * @var string contents of merchant's private key
	 */
	protected $privateKey;

	/**
	 * @var string provider's (Klix) public key
	 */
	protected $providerPublicKey;

	/**
	 * @var bool
	 */
	protected $debugEnabled;

	/**
	 * @var string
	 */
	protected $debugFile;

	/**
	 * @param string $baseUri
	 * @param string $merchantId
	 * @param string $privateKeyId
	 * @param string $privateKey
	 * @param string $providerPublicKey
	 */
	public function __construct($baseUri, $merchantId, $privateKeyId, $privateKey, $providerPublicKey)
	{
		$this->baseUri = $baseUri;
		$this->merchantId = $merchantId;
		$this->privateKeyId = $privateKeyId;
		$this->privateKey = $this->checkIfPresent($privateKey, 'privateKey');
		$this->providerPublicKey = $this->checkIfPresent($providerPublicKey, 'providerPublicKey');
	}

	/**
	 * @param $configurationPropertyValue
	 * @param $configurationPropertyName
	 * @return string
	 */
	protected function checkIfPresent($configurationPropertyValue, $configurationPropertyName)
	{
		Preconditions::checkNotNull($configurationPropertyValue, "Configuration property $configurationPropertyName value not specified");
		return $configurationPropertyValue;
	}

	/**
	 * @return string
	 */
	public function getBaseUri()
	{
		return $this->baseUri;
	}

	/**
	 * @return string
	 */
	public function getMerchantId()
	{
		return $this->merchantId;
	}

	/**
	 * @return string
	 */
	public function getPrivateKeyId()
	{
		return $this->privateKeyId;
	}

	/**
	 * @return string
	 */
	public function getPrivateKey()
	{
		return $this->privateKey;
	}

	/**
	 * @return string
	 */
	public function getPublicKey() {
		$private_key = openssl_pkey_get_private($this->getPrivateKey());
		$pem_public_key = openssl_pkey_get_details($private_key)['key'];
		$public_key = openssl_pkey_get_public($pem_public_key);
		return openssl_pkey_get_details($public_key)['key'];
	}

	/**
	 * @return string
	 */
	public function getProviderPublicKey()
	{
		return $this->providerPublicKey;
	}

	/**
	 * @return bool
	 */
	public function isDebugEnabled()
	{
		return $this->debugEnabled;
	}

	/**
	 * @return string
	 */
	public function getDebugFile()
	{
		return $this->debugFile;
	}
}
