<?php


namespace Klix\Api\Signing;


use HttpSignatures\Context;
use HttpSignatures\Exception;
use HttpSignatures\KeyStore;
use Klix\KlixConfiguration;

class SigningContextFactory
{

	/**
	 * @param KlixConfiguration $apiConfiguration
	 * @param $headers
	 * @return Context
	 * @throws Exception
	 */
	static function createSigningContext(KlixConfiguration $apiConfiguration, $headers) {
		$keyId = $apiConfiguration->getPrivateKeyId();
		$keystore = new KeyStore([$keyId => $apiConfiguration->getPrivateKey()]);
		return new Context([
			'keyStore' => $keystore,
			'signingKeyId' => $keyId,
			'algorithm' => 'rsa-sha256',
			'headers' => $headers,
		]);
	}

	/**
	 * @param KlixConfiguration $apiConfiguration
	 * @param $headers
	 * @return Context
	 * @throws Exception
	 */
	static function createVerificationContext(KlixConfiguration $apiConfiguration, $headers) {
		$keyId = $apiConfiguration->getPrivateKeyId();
		$keystore = new KeyStore([$keyId => $apiConfiguration->getPublicKey()]);
		return new Context([
			'keyStore' => $keystore,
			'signingKeyId' => $keyId,
			'algorithm' => 'rsa-sha256',
			'headers' => $headers,
		]);
	}
}
