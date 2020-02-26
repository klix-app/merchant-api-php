<?php

namespace Klix;


use Klix\Widget\WidgetConfigurationSigner;

class WidgetConfigurationSignerTest extends AbstractWidgetConfigurationTest
{

	public function testSigning() {
		$widgetConfiguration = $this->getWidgetConfiguration();
		$apiConfiguration = $this->getApiConfiguration();

		$widgetSigner = new WidgetConfigurationSigner($apiConfiguration);
		$signature = $widgetSigner->getSignature($widgetConfiguration);

		$this->assertEquals("T2mN980RRnm6eTmnggYNA51RkZ/NItnPF2H4Z/c92gyBM2MuX/u8KVuQsdBlt9XDUfFq6HA2sXIr1cN"
			. "WzUrTV51VHsuq5u17aTZ4a1rWPjdegjfVVI0ErIDXKrEHzvS1PJ0VvyFUBeZEQEXWTMyRGfCTgO8/pDWbEfwTXeY8HzqftaGj00ej5/"
			. "upGHhVn2SDVtGsp55I7uW/PIRUWCnxxZKwA/VzALUlTGgCGoxE9fhBiFVcOVPSi0sLUReL1yw21gRWLg/uMx6tuNHK25fvtLzVLO6Mi"
			. "gOruA5mFfT3jnHHczrkpjOeOJ+FwZ1mmkCOyCdPYC0G8CCF8C5EYBr4dA==", $signature);
	}
}
