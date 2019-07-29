<?php

namespace Klix\Merchant;

class OrderItem extends Model
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
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->values['currency'] = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->values['label'];
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->values['label'] = $label;
        return $this;
    }

    /**
     * @return float
     */
    public function getTaxAmount()
    {
        return $this->values['tax_amount'];
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
    public function getTaxRate()
    {
        return $this->values['taxRate'];
    }

    /**
     * @param float $taxRate
     * @return $this
     */
    public function setTaxRate($taxRate)
    {
        $this->values['taxRate'] = $taxRate;
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
