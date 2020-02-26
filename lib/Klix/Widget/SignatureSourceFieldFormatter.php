<?php


namespace Klix\Widget;


trait SignatureSourceFieldFormatter
{

	/**
	 * @param float $float
	 * @return string
	 */
	function amountToString($float) {
		return $this->floatToString($float, 2);
	}

	/**
	 * @param float $float
	 * @param number $decimalPlaces
	 * @return string
	 */
	function floatToString($float, $decimalPlaces) {
		return $float !== null ? sprintf("%.${decimalPlaces}f", $float) : "";
	}

	/**
	 * @param $string
	 * @return string
	 */
	function nullToEmptyString($string) {
		return $string != null ? $string : "";
	}
}
