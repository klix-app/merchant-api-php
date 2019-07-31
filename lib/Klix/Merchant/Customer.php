<?php

namespace Klix\Merchant;

class Customer extends Model
{
	/**
	 * @return string
	 */
    public function getDateOfBirth()
    {
        return $this->values['dateOfBirth'];
    }

	/**
	 * @param $dateOfBirth string
	 * @return $this
	 */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->values['dateOfBirth'] = $dateOfBirth;
        return $this;
    }

	/**
	 * @return string
	 */
    public function getNin()
    {
        return $this->values['nin'];
    }

	/**
	 * @param $nin string
	 * @return $this
	 */
    public function setNin($nin)
    {
        $this->values['nin'] = $nin;
        return $this;
    }
}
