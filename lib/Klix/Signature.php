<?php

namespace Klix;

use Firebase\JWT\JWT;
use UnexpectedValueException;

class Signature
{
	const ALGORITHM = 'RS256';

	/**
	 * @param $arr array
	 * @param $apiConfiguration ApiConfiguration
	 * @return string signed JWT
	 */
	static function sign($arr, $apiConfiguration)
	{
		$jwt = JWT::encode($arr, $apiConfiguration->getPrivateKey(), self::ALGORITHM, $apiConfiguration->getPrivateKeyId());
		return $jwt;
	}

	/**
	 * @param $signedContent string
	 * @param $apiConfiguration ApiConfiguration
	 * @throws SignatureValidationFailedException
	 * @return array
	 */
	static function decode($signedContent, $apiConfiguration)
	{
		try {
			$jwtPayload = JWT::decode($signedContent, $apiConfiguration->getProviderPublicKey(), [self::ALGORITHM]);
			return json_decode(json_encode($jwtPayload), true);
		} catch (UnexpectedValueException $ex) {
			throw new SignatureValidationFailedException('Signed JWT validation failed', null, $ex);
		}
	}
}
