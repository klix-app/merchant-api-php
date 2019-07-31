<?php

namespace Klix\Merchant;


use Klix\BaseApiClientTest;

class RequestDecoderTest extends BaseApiClientTest
{

	public function testDecodeOrderVerificationRequest()
	{
		$signedRequest = $this->getTestResourceFileContents('signed-jwt/SignedRequest.txt');

		$orderVerificationRequest = RequestDecoder::decodeOrderVerificationRequest($signedRequest, $this->apiConfiguration);

		$this->assertEquals('6737d6a5-231e-48df-8570-fe49859f7d7d', $orderVerificationRequest->getOrderId());
	}
}
