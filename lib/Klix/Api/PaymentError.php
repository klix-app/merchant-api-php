<?php

namespace Klix\Api;

class PaymentError extends Model
{
	/**
	 * @return string
	 */
    public function getCode()
    {
        return $this->values['code'];
    }

	/**
	 * @param $code string
	 * @return $this
	 */
    public function setCode($code)
    {
        $this->values['code'] = $code;
        return $this;
    }

	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->values['message'];
	}

	/**
	 * @param $message string
	 * @return $this
	 */
	public function setMessage($message)
	{
		$this->values['message'] = $message;
		return $this;
	}
}
