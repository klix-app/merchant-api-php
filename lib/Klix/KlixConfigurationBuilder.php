<?php

namespace Klix;

class KlixConfigurationBuilder
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
	 * @return KlixConfigurationBuilder
	 */
	public function setBaseUri($baseUri)
	{
		$this->baseUri = $baseUri;
		return $this;
	}

	/**
	 * @param string $merchantId
	 *
	 * @return KlixConfigurationBuilder
	 */
	public function setMerchantId($merchantId)
	{
		$this->merchantId = $merchantId;
		return $this;
	}

	/**
	 * @param string $privateKeyId
	 *
	 * @return KlixConfigurationBuilder
	 */
	public function setPrivateKeyId($privateKeyId)
	{
		$this->privateKeyId = $privateKeyId;
		return $this;
	}

	/**
	 * @param string $privateKey
	 *
	 * @return KlixConfigurationBuilder
	 */
	public function setPrivateKey($privateKey)
	{
		$this->privateKey = $privateKey;
		return $this;
	}

	/**
	 * @param string $providerPublicKey
	 *
	 * @return KlixConfigurationBuilder
	 */
	public function setProviderPublicKey($providerPublicKey)
	{
		$this->providerPublicKey = $providerPublicKey;
		return $this;
	}

	/**
	 * @param bool $debugEnabled
	 *
	 * @return KlixConfigurationBuilder
	 */
	public function setDebugEnabled($debugEnabled)
	{
		$this->debugEnabled = $debugEnabled;
		return $this;
	}

	/**
	 * @param string $debugFile
	 *
	 * @return KlixConfigurationBuilder
	 */
	public function setDebugFile($debugFile)
	{
		$this->debugFile = $debugFile;
		return $this;
	}

	/**
	 * @return KlixConfiguration
	 */
	public function build()
	{
		return new KlixConfiguration(
			$this->baseUri,
			$this->merchantId,
			$this->privateKeyId,
			$this->privateKey,
			$this->providerPublicKey
		);
	}

	public static function builder() {
		return new KlixConfigurationBuilder();
	}
}
