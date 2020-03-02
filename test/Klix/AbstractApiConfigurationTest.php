<?php


namespace Klix;


use PHPUnit_Framework_TestCase;

abstract class AbstractApiConfigurationTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @return KlixConfiguration
	 */
	protected function getApiConfiguration()
	{
		return KlixConfigurationBuilder::builder()
			->setPrivateKey($this->getTestResourceFileContents('keys/merchant_private_key.pem'))
			->setPrivateKeyId('52a49f81-0869-40a6-8dde-96a624e61b54')
			->setProviderPublicKey($this->getTestResourceFileContents('keys/provider_public_key.pem'))
			->build();
	}

	/**
	 * @param $fileName
	 * @return false|string
	 */
	protected function getTestResourceFileContents($fileName)
	{
		$fullFileName = dirname(__DIR__) . '/Klix/resources/' . $fileName;
		return file_get_contents($fullFileName);
	}
}
