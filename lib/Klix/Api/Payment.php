<?php

namespace Klix\Api;

class Payment extends Model
{
	/**
	 * @return string
	 */
    public function getMethod()
    {
        return $this->values['method'];
    }

	/**
	 * @param $method string
	 * @return $this
	 */
    public function setMethod($method)
    {
        $this->values['method'] = $method;
        return $this;
    }

	/**
	 * @return string
	 */
    public function getStatus()
    {
        return $this->values['status'];
    }

	/**
	 * @param $status string
	 * @return $this
	 */
    public function setStatus($status)
    {
        $this->values['status'] = $status;
        return $this;
    }

	/**
	 * @return string
	 */
	public function getAccountStatementReference()
	{
		return $this->values['accountStatementReference'];
	}

	/**
	 * @param $accountStatementReference string
	 * @return $this
	 */
	public function setAccountStatementReference($accountStatementReference)
	{
		$this->values['accountStatementReference'] = $accountStatementReference;
		return $this;
	}

	/**
	 * @return Card
	 */
	public function getCard()
	{
		return new Card($this->values['card']);
	}

	/**
	 * @param Card $card
	 * @return $this
	 */
	public function setCard($card)
	{
		$this->values['card'] = $card->values;
		return $this;
	}

	/**
	 * @return PaymentError
	 */
	public function getError()
	{
		return new PaymentError($this->values['error']);
	}

	/**
	 * @param PaymentError $error
	 * @return $this
	 */
	public function setPaymentError($error)
	{
		$this->values['error'] = $error->values;
		return $this;
	}
}
