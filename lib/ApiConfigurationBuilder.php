<?php

namespace Klix;

class ApiConfigurationBuilder
{

	/**
	 * @var string
	 */
	protected $baseUri;

	/**
	 * @var string
	 */
	protected $merchantId;

	/**
	 * @var string
	 */
	protected $apiKey;

	/**
	 * @var string
	 */
	protected $privateKeyId;

	/**
	 * @var string
	 */
	protected $privateKey;

	/**
	 * @var string
	 */
	protected $providerPublicKey;

	/**
	 * @var bool
	 */
	protected $debugEnabled = false;

	/**
	 * @var string
	 */
	protected $debugFile = 'php://output';

	protected function __construct()
	{
	}

	/**
	 * @param string $baseUri
	 *
	 * @return ApiConfigurationBuilder
	 */
	public function setBaseUri($baseUri)
	{
		$this->baseUri = $baseUri;
		return $this;
	}

	/**
	 * @param string $merchantId
	 *
	 * @return ApiConfigurationBuilder
	 */
	public function setMerchantId($merchantId)
	{
		$this->merchantId = $merchantId;
		return $this;
	}

	/**
	 * @param string $apiKey
	 *
	 * @return ApiConfigurationBuilder
	 */
	public function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;
		return $this;
	}

	/**
	 * @param string $privateKeyId
	 *
	 * @return ApiConfigurationBuilder
	 */
	public function setPrivateKeyId($privateKeyId)
	{
		$this->privateKeyId = $privateKeyId;
		return $this;
	}

	/**
	 * @param string $privateKey
	 *
	 * @return ApiConfigurationBuilder
	 */
	public function setPrivateKey($privateKey)
	{
		$this->privateKey = $privateKey;
		return $this;
	}

	/**
	 * @param string $providerPublicKey
	 *
	 * @return ApiConfigurationBuilder
	 */
	public function setProviderPublicKey($providerPublicKey)
	{
		$this->providerPublicKey = $providerPublicKey;
		return $this;
	}

	/**
	 * @param bool $debugEnabled
	 *
	 * @return ApiConfigurationBuilder
	 */
	public function setDebugEnabled($debugEnabled)
	{
		$this->debugEnabled = $debugEnabled;
		return $this;
	}

	/**
	 * @param string $debugFile
	 *
	 * @return ApiConfigurationBuilder
	 */
	public function setDebugFile($debugFile)
	{
		$this->debugFile = $debugFile;
		return $this;
	}

	/**
	 * @return ApiConfiguration
	 */
	public function build()
	{
		return new ApiConfiguration(
			$this->baseUri,
			$this->merchantId,
			$this->apiKey,
			$this->privateKeyId,
			$this->privateKey,
			$this->providerPublicKey
		);
	}

	public static function builder() {
		return new ApiConfigurationBuilder();
	}
}
