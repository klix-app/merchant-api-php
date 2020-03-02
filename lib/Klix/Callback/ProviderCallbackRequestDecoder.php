<?php


namespace Klix\Callback;


use Klix\Merchant\MerchantOrder;
use Klix\SignatureValidationFailedException;

class ProviderCallbackRequestDecoder
{

	/**
	 * @var ProviderSignatureValidator
	 */
	protected $providerSignatureValidator;

	/**
	 * @param ProviderSignatureValidator $providerSignatureValidator
	 */
	public function __construct(ProviderSignatureValidator $providerSignatureValidator)
	{
		$this->providerSignatureValidator = $providerSignatureValidator;
	}

	/**
	 * @param string $payload request body
	 * @param string $signature signature header value
	 * @return MerchantOrder
	 */
	public function decodePurchaseFinalizedRequest($payload, $signature)
	{
		return $this->decodeRequest($payload, $signature, 'Klix\Merchant\MerchantOrder');
	}

	/**
	 * @param string $payload request body
	 * @param string $signature signature header value
	 * @param string $objectClass result object class
	 * @return mixed
	 */
	private function decodeRequest($payload, $signature, $objectClass)
	{
		if (!$this->providerSignatureValidator->isValid($payload, $signature)) {
			throw new SignatureValidationFailedException("Invalid signature $signature");
		}
		$propertyMap = json_decode($payload, true);
		return new $objectClass($propertyMap);
	}
}
