<?php

namespace Klix;


class WidgetConfigurationTest extends AbstractWidgetConfigurationTest
{

	public function testSignatureSource() {
		$widgetConfiguration = $this->getWidgetConfiguration();

		$signatureSource = $widgetConfiguration->toSignatureSource();

		self::assertEquals("d700a786-56da-11ea-8e2d-0242ac130003"
			. "lv"
			. "6af6c4fc-56db-11ea-8e2d-0242ac130003"

			. "36c420f4-5487-11ea-a2e3-2e728ce88125"
			. "122.99"
			. "EUR"
			. "Vacuum cleaner TC31"
			. "2.000"
		    . "PIECE"
			. "0.21"
			. "ff713414-56f9-11ea-82b4-0242ac130003"

			. "7.05"
			. "EUR"
			. "Filter for TC31"

			. "courier"
			. "3.00"

			. "pickup"
			. "0.00"
			. "EUR"

			. "Citadele", $signatureSource);
	}
}
