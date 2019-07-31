<?php

namespace Klix;

use Closure;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

class RequestMatchers
{
	/**
	 * @param $httpMethod string
	 * @return Closure
	 */
	public static function httpMethodIs($httpMethod) {
		return function(Request $request) use ($httpMethod) {
			return $request->getMethod() == $httpMethod;
		};
	}

	/**
	 * @param $requestUri Uri
	 * @return Closure
	 */
	public static function requestUriIs($requestUri) {
		return function(Request $request) use ($requestUri) {
			return $request->getUri() == $requestUri;
		};
	}

	/**
	 * @param $apiKey string
	 * @return Closure
	 */
	public static function containsHeaders($apiKey) {
		return function(Request $request) use ($apiKey) {
			$headers = [
				'X-KLIX-Api-Key' => $apiKey,
				'Accept' => 'application/json',
				'Content-Type' => 'application/json'
			];
			foreach ($headers as $headerName => $headerValue) {
				if ($request->getHeaderLine($headerName) !== $headerValue) {
					return false;
				}
			}
			return true;
		};
	}

	/**
	 * @param $requestBody string
	 * @return Closure
	 */
	public static function requestBodyMatches($requestBody) {
		return function(Request $request) use ($requestBody) {
			return $request->getBody()->getContents() == $requestBody;
		};
	}
}
