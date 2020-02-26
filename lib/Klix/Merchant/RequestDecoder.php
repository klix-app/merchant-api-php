<?php

namespace Klix\Merchant;

use Klix\KlixConfiguration;
use Klix\Signature;
use Klix\SignatureValidationFailedException;

class RequestDecoder
{

	/**
	 * @param $signedRequestContent string
	 * @param $apiConfiguration KlixConfiguration
	 * @return MerchantOrderVerificationRequest
	 *@throws SignatureValidationFailedException
	 */
	public static function decodeOrderVerificationRequest($signedRequestContent, $apiConfiguration)
	{
		return RequestDecoder::decode(
			$signedRequestContent,
			$apiConfiguration,
			'Klix\Merchant\MerchantOrderVerificationRequest'
		);
	}

	/**
	 * @param $signedRequestContent string
	 * @param $apiConfiguration KlixConfiguration
	 * @return MerchantPurchaseFinalizedNotificationRequest
	 *@throws SignatureValidationFailedException
	 */
	public static function decodePurchaseFinalizedNotificationRequest($signedRequestContent, $apiConfiguration)
	{
		return RequestDecoder::decode(
			$signedRequestContent,
			$apiConfiguration,
			'Klix\Merchant\MerchantPurchaseFinalizedNotificationRequest'
		);
	}

	/**
	 * @param $signedRequestContent string
	 * @param $apiConfiguration KlixConfiguration
	 * @param $objectClass string
	 * @return mixed
	 *@throws SignatureValidationFailedException
	 */
	protected static function decode($signedRequestContent, $apiConfiguration, $objectClass)
	{
		$decodedRequestContent = Signature::decode($signedRequestContent, $apiConfiguration);
		return new $objectClass($decodedRequestContent);
	}
}
