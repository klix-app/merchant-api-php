<?php

namespace Klix;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class ApiClient
{

	/**
	 * @var KlixConfiguration
	 */
	protected $apiConfiguration;

	/**
	 * @var ClientInterface
	 */
	protected $httpClient;

	public function __construct(KlixConfiguration $apiConfiguration, ClientInterface $httpClient = null)
	{
		$this->apiConfiguration = $apiConfiguration;
		$this->httpClient = $httpClient === null ? new Client() : $httpClient;
	}

	/**
	 * Create request
	 *
	 * @param string method
	 * @param string resourcePathTemplate
	 * @param array pathVariables
	 * @param mixed[] $requestBody
	 *
	 * @return Request
	 */
	public function createRequest($method, $resourcePathTemplate, $pathVariables, $requestBody = null)
	{
		$headers = [
			'Content-Type' => 'application/json',
			'Accept' => 'application/json',
			'User-Agent' => 'Klix/1.0.0/php',
			'X-KLIX-Api-Key' => $this->apiConfiguration->getApiKey(),
		];
		$signedRequestBody = $requestBody === null ? null : Signature::sign($requestBody, $this->apiConfiguration);
		$resourcePath = $this->replacePathVariables($resourcePathTemplate, $pathVariables);
		return new Request(
			$method,
			$this->apiConfiguration->getBaseUri() . $resourcePath,
			$headers,
			$signedRequestBody
		);
	}

	protected function replacePathVariables($template, $variables)
	{
		$allVariables = array_merge(["merchantId" => $this->apiConfiguration->getMerchantId()], $variables);
		foreach ($allVariables as $key => $value) {
			$template = str_replace('{' . $key . '}', ObjectSerializer::toPathValue($value), $template);
		}

		return $template;
	}

	/**
	 * @param $request Request
	 * @param $returnType string
	 * @return mixed
	 * @throws ApiException
	 */
	public function makeHttpCall($request, $returnType = null)
	{
		$response = $this->sendRequest($request);
		$this->checkResponseStatusCode($request, $response);
		$responseBody = $response->getBody();
		$content = json_decode($responseBody->getContents(), true);
		return $returnType != null ? new $returnType($content) : null;
	}

	/**
	 * @param $request
	 * @return ResponseInterface
	 * @throws ApiException
	 */
	protected function sendRequest($request)
	{
		$options = $this->createHttpClientOption();
		try {
			return $this->httpClient->send($request, $options);
		} catch (RequestException $exception) {
			throw $this->toApiException($exception);
		} catch (GuzzleException $guzzleException) {
			throw new ApiException($guzzleException->getMessage(), $guzzleException->getCode());
		}
	}

	/**
	 * Create http client options
	 *
	 * @throws RuntimeException on file opening failure
	 * @return array of http client options
	 */
	protected function createHttpClientOption()
	{
		$options = [];
		if ($this->apiConfiguration->isDebugEnabled()) {
			$options[RequestOptions::DEBUG] = fopen($this->apiConfiguration->getDebugFile(), 'a');
			if (!$options[RequestOptions::DEBUG]) {
				throw new RuntimeException('Failed to open debug file: ' . $this->apiConfiguration->getDebugFile());
			}
		}
		return $options;
	}

	/**
	 * @param $e RequestException
	 *
	 * @return ApiException
	 */
	protected function toApiException($e) {
		return new ApiException(
			"[{$e->getCode()}] {$e->getMessage()}",
			$e->getCode(),
			$e->getResponse() ? $e->getResponse()->getHeaders() : null,
			$e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
		);
	}

	/**
	 * @param $request Request
	 * @param $response ResponseInterface
	 * @throws ApiException
	 */
	protected function checkResponseStatusCode($request, $response) {
		$statusCode = $response->getStatusCode();
		if ($statusCode < 200 || $statusCode > 299) {
			throw new ApiException(
				sprintf(
					'[%d] Error connecting to the API (%s)',
					$statusCode,
					$request->getUri()
				),
				$statusCode,
				$response->getHeaders(),
				$response->getBody()
			);
		}
	}
}
