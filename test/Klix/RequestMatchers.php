<?php

namespace Klix;

use Closure;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Klix\Api\ApiClient;

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
	 * @param $headerName string
	 * @param $headerValue string
	 * @return Closure
	 */
	public static function containsHeader($headerName, $headerValue) {
		return self::headerValueMatches($headerName, function(string $actualHeaderValue) use ($headerName, $headerValue) {
			if ($actualHeaderValue === $headerValue) {
				return true;
			} else {
				echo "Expected header $headerName value \"$headerValue\" but was \"$actualHeaderValue\"";
				return false;
			}
		});
	}

	/**
	 * @param $headerName string
	 * @param $headerValueClosure Closure
	 * @return Closure
	 */
	public static function headerValueMatches($headerName, $headerValueClosure) {
		return function(Request $request) use ($headerName, $headerValueClosure) {
			$actualHeaderValue = $request->getHeaderLine($headerName);
			return $headerValueClosure($actualHeaderValue);
		};
	}

	/**
	 * @param $requestBody string
	 * @return Closure
	 */
	public static function requestBodyMatches($requestBody) {
		return function(Request $request) use ($requestBody) {
			$request->getBody()->rewind();
			$actualBody = $request->getBody()->getContents();
			if ($actualBody == $requestBody) {
				return true;
			} else {
				echo "Expected HTTP request body value \"$requestBody\" but was \"$actualBody\"";
				return false;
			}
		};
	}

	/**
	 * @param $apiClient ApiClient
	 * @return Closure
	 */
	public static function signatureIsValid($apiClient) {
		return function(Request $request) use ($apiClient) {
			return $apiClient->isSignatureValid($request);
		};
	}
}
