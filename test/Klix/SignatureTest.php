<?php

namespace Klix;

use Klix\Merchant\MerchantOrderVerificationRequest;

class SignatureTest extends BaseApiClientTest
{

	public function testSigning()
	{
		$expectedSignedJwt = $this->getTestResourceFileContents('signed-jwt/SignatureTest.txt');
		$contentToSign = [
			'id' => '4d53e036-dbf3-46c1-8e5b-bcf1326b817f',
			'status' => 'PENDING',
			'customer' => [
				'id' => '883b0e16-a58d-4ade-b01d-e28b797cc2fb',
				'fullName' => 'John Doe'
			]
		];

		$actualSignedJwt = Signature::sign($contentToSign, $this->apiConfiguration);

		$this->assertEquals($expectedSignedJwt, $actualSignedJwt);
	}

	public function testValidSignedRequestDecoding()
	{
		$signedJwt = $this->getTestResourceFileContents('signed-jwt/SignedRequest.txt');
		$jwtPayload = Signature::decode($signedJwt, $this->apiConfiguration);
		$verificationRequest = new MerchantOrderVerificationRequest($jwtPayload);

		self::assertEquals("6737d6a5-231e-48df-8570-fe49859f7d7d", $verificationRequest->getOrderId());
	}

	public function testInvalidSignedRequestDecoding()
	{
		$signedJwt = $this->getTestResourceFileContents('signed-jwt/InvalidSignedRequest.txt');
		$this->setExpectedException(SignatureValidationFailedException::class);

		Signature::decode($signedJwt, $this->apiConfiguration);
	}
}
