<?php

namespace Klix\Callback;


use Klix\AbstractApiConfigurationTest;

class ProviderSignatureValidatorTest extends AbstractApiConfigurationTest
{

	function testValidSignatureValidation()
	{
		$validator = new ProviderSignatureValidator($this->getApiConfiguration());
		$payload = $this->getTestResourceFileContents('responses/purchase-notification.json');
		$signature = 'MKqXr7siOkC6TYENeHUcy5ofFDiWpqMt+ow5iWJqnIYWU71W50fZFHfy3BVrehEGCvf+TufZK6DPymdM1e2G0w==';

		$isValid = $validator->isValid($payload, $signature);

		self::assertTrue($isValid);
	}

	function testInvalidSignatureValidation()
	{
		$validator = new ProviderSignatureValidator($this->getApiConfiguration());
		$payload = $this->getTestResourceFileContents('responses/purchase-notification.json');
		$signature = 'mxeCmiKKycjMSrIyu66tlwzGDMhoOtOBMNsIMPQlmdWtDjJF2O3XxBaEDxPj2UWCSnAQYhp4GinRrHttT21t9A==';

		$isValid = $validator->isValid($payload, $signature);

		self::assertFalse($isValid);
	}

}
