<?php

namespace Klix\Api;

class OrderRefund extends Model
{

	/**
	 * @return float
	 */
	public function getAmount()
	{
		return $this->values['amount'];
	}

	/**
	 * @param float $amount
	 * @return $this
	 */
	public function setAmount($amount)
	{
		$this->values['amount'] = $amount;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getReason()
	{
		return $this->values['reason'];
	}

	/**
	 * @param string $reason
	 * @return $this
	 */
	public function setReason($reason)
	{
		$this->values['reason'] = $reason;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNote()
	{
		return $this->values['note'];
	}

	/**
	 * @param string $note
	 * @return $this
	 */
	public function setNote($note)
	{
		$this->values['note'] = $note;
		return $this;
	}
}
