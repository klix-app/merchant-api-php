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

		$this->assertEquals("EbaePsGwMZRfAZaSVK3bnMpiTTBTQy6ZlF19GMleadr+lG44QW7m2btARsrEsg7K9EQ3orsAKiMvoCFS"
			. "emjp4iOvYr1/XkOGs3WMxq9QFriZkFiqeBEOvkKVZ68DrR5Jkp/on8T06PHqjVbXV15INNpLwQfuyElD8/ElPARJecx9VYeeeUPmBFgn"
			. "39xu2x2JrMW51GZ0bJyLi2yReLW3sNy7fwRGMdqNDD4TBidij+egtTEA9x8kfYXG+vPQWVmtjIiHMaNZ62WxwKsWf7dCzbTCSdi3XWXR"
			. "Rh5bE0oJOHMWZ9peI1bKqNRn5GAeIGCBqTY2vtwq9qE9hji1QkKiAA==", $signature);
	}
}
