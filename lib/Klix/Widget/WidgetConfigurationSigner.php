<?php


namespace Klix\Widget;


use Klix\KlixConfiguration;

class WidgetConfigurationSigner
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
	 * @param WidgetConfiguration $widgetConfiguration
	 * @return string
	 */
	public function getSignature($widgetConfiguration) {
		$signatureSource = $widgetConfiguration->toSignatureSource();
		openssl_sign($signatureSource, $signature, $this->apiConfiguration->getPrivateKey(), OPENSSL_ALGO_SHA256);
		return base64_encode($signature);
	}
}
