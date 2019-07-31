<?php

namespace Klix\Merchant;

use Klix\ApiConfiguration;
use Klix\Signature;
use Klix\SignatureValidationFailedException;

class RequestDecoder
{

	/**
	 * @param $signedRequestContent string
	 * @param $apiConfiguration ApiConfiguration
	 * @throws SignatureValidationFailedException
	 * @return MerchantOrderVerificationRequest
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
	 * @param $apiConfiguration ApiConfiguration
	 * @throws SignatureValidationFailedException
	 * @return MerchantPurchaseFinalizedNotificationRequest
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
	 * @param $apiConfiguration ApiConfiguration
	 * @param $objectClass string
	 * @throws SignatureValidationFailedException
	 * @return mixed
	 */
	protected static function decode($signedRequestContent, $apiConfiguration, $objectClass)
	{
		$decodedRequestContent = Signature::decode($signedRequestContent, $apiConfiguration);
		return new $objectClass($decodedRequestContent);
	}
}
