<?php

namespace Klix\Api\Signing;

use Psr\Http\Message\RequestInterface;

interface RequestSignerInterface {

	/**
	 * @param RequestInterface $request
	 * @return RequestInterface
	 */
	function sign(RequestInterface $request);

	/**
	 * @param RequestInterface $request
	 * @return bool
	 */
	function isValid(RequestInterface $request);
}
