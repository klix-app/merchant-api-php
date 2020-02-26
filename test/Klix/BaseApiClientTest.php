<?php

namespace Klix;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;

abstract class BaseApiClientTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var KlixConfiguration
	 */
	protected $apiConfiguration;

	protected $invocations = [];

	protected $mockResponses = [];

	public final function setUp()
	{
		$this->createApiConfiguration();
		$this->createApiClient();
		$this->beforeTest();
	}

	protected function createApiConfiguration()
	{
		$this->apiConfiguration = KlixConfigurationBuilder::builder()
			->setBaseUri(KlixConfiguration::TEST_BASE_URL)
			->setApiKey('52a49f81-0869-40a6-8dde-96a624e61b54')
			->setMerchantId('f6cef80b-92a4-4bc2-b611-7dc597f9ba60')
			->setPrivateKey($this->getTestResourceFileContents('keys/merchant_private_key.pem'))
			->setPrivateKeyId('52a49f81-0869-40a6-8dde-96a624e61b54')
			->setProviderPublicKey($this->getTestResourceFileContents('keys/provider_public_key.pem'))
			->setDebugEnabled(true)
			->build();
	}

	protected function getTestResourceFileContents($fileName)
	{
		$fullFileName = dirname(__DIR__) . '/Klix/resources/' . $fileName;
		return file_get_contents($fullFileName);
	}

	/**
	 * @return ApiClient
	 */
	protected function createApiClient()
	{
		return new ApiClient($this->apiConfiguration, $this->createMockHttpHandler());
	}

	protected function beforeTest()
	{
	}

	/**
	 * @return Client
	 */
	private function createMockHttpHandler() {
		$mockHandler = new MockHandler($this->mockResponses);
		$history = Middleware::history($this->invocations);
		$handlerStack = HandlerStack::create($mockHandler);
		$handlerStack->push($history);
		return new Client(['handler' => $handlerStack]);
	}

	/**
	 * @param $httpStatusCode int
	 * @param $responseBody string
	 */
	protected function providerRespondsWith($httpStatusCode, $responseBody = null)
	{
		$responseHeaders = [
			'Content-Type' => 'application/json'
		];
		$response = new Response($httpStatusCode, $responseHeaders, $responseBody);
		$this->providerResponds($response);
	}

	/**
	 * @param $response Response
	 */
	protected function providerResponds($response)
	{
		array_push($this->mockResponses, $response);
	}

	/**
	 * @param array $requestMatcherPredicates
	 * @return Request
	 */
	protected function requestMatched($requestMatcherPredicates) {
		$filtered = array_filter($this->invocations, function($invocation) use ($requestMatcherPredicates) {
			foreach ($requestMatcherPredicates as $requestMatcherPredicate) {
				$matched = $requestMatcherPredicate($invocation['request']);
				if (!$matched) {
					return false;
				}
			}
			return true;
		});
		$this->assertCount(1, $filtered, sizeof($filtered) . ' requests matched specified predicate');
		return $filtered[0];
	}
}
