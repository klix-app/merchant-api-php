<?php

namespace Klix\Api;

class MerchantUrls extends Model
{
	/**
	 * @return string
	 */
    public function getConfirmation()
    {
        return $this->values['confirmation'];
    }

	/**
	 * @param string $confirmation
	 * @return $this
	 */
    public function setConfirmation($confirmation)
    {
        $this->values['confirmation'] = $confirmation;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceOrder()
    {
        return $this->values['place_order'];
    }

    /**
     * @param string $placeOrder
     * @return $this
     */
    public function setPlaceOrder($placeOrder)
    {
        $this->values['place_order'] = $placeOrder;
        return $this;
    }

    /**
     * @return string
     */
    public function getTerms()
    {
        return $this->values['terms'];
    }

    /**
     * @param string $terms
     * @return $this
     */
    public function setTerms($terms)
    {
        $this->values['terms'] = $terms;
        return $this;
    }

    /**
     * @return string
     */
    public function getVerification()
    {
        return $this->values['verification'];
    }

    /**
     * @param string $verification
     * @return $this
     */
    public function setVerification($verification)
    {
        $this->values['verification'] = $verification;
        return $this;
    }
}
