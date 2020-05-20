<?php


namespace Klix\Api\Signing;


use DateTime;
use DateTimeZone;
use Exception;
use HttpSignatures\Context;
use Klix\KlixConfiguration;
use Psr\Http\Message\RequestInterface;

class RequestWithBodySigner implements RequestSignerInterface
{
	/**
	 * @var Context
	 */
	protected $signingContext;

	/**
	 * @var
	 */
	protected $verificationContext;

	/**
	 * @param KlixConfiguration $apiConfiguration
	 * @throws \HttpSignatures\Exception
	 */
	public function __construct(KlixConfiguration $apiConfiguration)
	{
		$headers = ['(request-target)', 'date', 'content-type', 'digest'];
		$this->signingContext = SigningContextFactory::createSigningContext($apiConfiguration, $headers);
		$this->verificationContext = SigningContextFactory::createVerificationContext($apiConfiguration, $headers);
	}

	function sign(RequestInterface $request)
	{
		$signer = $this->signingContext->signer();
		return $signer->authorizeWithDigest($this->addAdditionalHeaders($request));
	}

	/**
	 * @param RequestInterface $request
	 * @return RequestInterface
	 * @throws Exception
	 */
	function addAdditionalHeaders(RequestInterface $request) {
		$currentDateTime = new DateTime('now', new DateTimeZone('GMT'));
		return $request
			->withHeader('date', $currentDateTime->format('D, d M Y H:i:s O'))
			->withHeader('Content-Type', 'application/json');
	}

	/**
	 * @param RequestInterface $request
	 * @return bool
	 */
	function isValid(RequestInterface $request)
	{
		return $this->verificationContext->verifier()->isAuthorizedWithDigest($request);
	}
}
