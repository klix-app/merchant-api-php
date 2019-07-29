<?php

namespace Klix\Merchant;

class OrderTotal extends Model
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
    public function getCurrency()
    {
        return $this->values['currency'];
    }

    /**
     * @param string $currency currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->values['currency'] = $currency;
        return $this;
    }

    /**
     * @return float
     */
    public function getTaxAmount()
    {
        return $this->values['taxAmount'];
    }

    /**
     * @param float $taxAmount
     * @return $this
     */
    public function setTaxAmount($taxAmount)
    {
        $this->values['taxAmount'] = $taxAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->values['totalAmount'];
    }

    /**
     * @param float $totalAmount
     * @return $this
     */
    public function setTotalAmount($totalAmount)
    {
        $this->values['totalAmount'] = $totalAmount;
        return $this;
    }
}
