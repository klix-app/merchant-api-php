<?php


namespace Klix\Api\Signing;


use HttpSignatures\Exception;
use Klix\KlixConfiguration;
use Psr\Http\Message\RequestInterface;

class RequestSigner implements RequestSignerInterface
{

	/**
	 * @var RequestWithBodySigner
	 */
	protected $requestWithBodySigner;

	/**
	 * @var RequestWithoutBodySigner
	 */
	protected $requestWithoutBodySigner;

	/**
	 * @param KlixConfiguration $apiConfiguration
	 * @throws Exception
	 */
	public function __construct(KlixConfiguration $apiConfiguration)
	{
		$this->requestWithBodySigner = new RequestWithBodySigner($apiConfiguration);
		$this->requestWithoutBodySigner = new RequestWithoutBodySigner($apiConfiguration);
	}

	/**
	 * @param RequestInterface $request
	 * @return RequestInterface
	 */
	function sign(RequestInterface $request)
	{
		return $this->getActualRequestSigner($request)->sign($request);
	}

	function isValid(RequestInterface $request)
	{
		return $this->getActualRequestSigner($request)->isValid($request);
	}

	/**
	 * @param RequestInterface $request
	 * @return RequestSignerInterface
	 */
	private function getActualRequestSigner(RequestInterface $request) {
		return ($request->getBody()->getSize() > 0) ? $this->requestWithBodySigner : $this->requestWithoutBodySigner;
	}
}
