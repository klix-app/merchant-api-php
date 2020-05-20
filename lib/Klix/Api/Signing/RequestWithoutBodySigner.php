<?php


namespace Klix\Api\Signing;


use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use HttpSignatures\Context;
use Klix\KlixConfiguration;
use Psr\Http\Message\RequestInterface;

class RequestWithoutBodySigner implements RequestSignerInterface
{
	/**
	 * @var Context
	 */
	protected $context;

	/**
	 * @param KlixConfiguration $apiConfiguration
	 * @throws \HttpSignatures\Exception
	 */
	public function __construct(KlixConfiguration $apiConfiguration)
	{
		$this->context = SigningContextFactory::createSigningContext($apiConfiguration, ['(request-target)', 'date']);
	}

	function sign(RequestInterface $request)
	{
		$signer = $this->context->signer();
		return $signer->authorize($this->addDateTimeHeader($request));
	}

	/**
	 * @param RequestInterface $request
	 * @return RequestInterface
	 * @throws Exception
	 */
	function addDateTimeHeader(RequestInterface $request) {
		$currentDateTime = new DateTime('now', DateTimeZone::UTC);
		return $request->withHeader('date', $currentDateTime->format(DateTimeInterface::RFC1123));
	}

	/**
	 * @param RequestInterface $request
	 * @return bool
	 * @throws \HttpSignatures\Exception
	 */
	function isValid(RequestInterface $request)
	{
		return $this->context->verifier()->isAuthorized($request);
	}
}
