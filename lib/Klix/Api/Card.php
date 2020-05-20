<?php

namespace Klix\Api;

class Card extends Model
{
	/**
	 * @return string
	 */
    public function getBin()
    {
        return $this->values['bin'];
    }

	/**
	 * @param $bin string
	 * @return $this
	 */
    public function setBin($bin)
    {
        $this->values['bin'] = $bin;
        return $this;
    }
}
