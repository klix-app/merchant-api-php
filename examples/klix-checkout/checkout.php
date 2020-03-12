<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once 'ShippingOptions.php';

use Klix\KlixConfigurationBuilder;
use Klix\Widget\CheckoutWidgetFactory;
use Klix\Widget\Order;
use Klix\Widget\OrderItem;
use Klix\Widget\WidgetConfiguration;
use Klix\Widget\WidgetConfigurationSigner;

define("CONFIG", parse_ini_file("./config_test_env.ini"));

function printKlixWidget()
{
	$order = Order::create()
		->setOrderId($_POST["orderId"]);
	addOrderItems($order);
	addShippingOptions($order);

	$widgetConfiguration = WidgetConfiguration::create()
		->setWidgetId(CONFIG['widget_id'])
		->setLanguage($_POST["language"])
		->setOrder($order);
	$apiConfiguration = KlixConfigurationBuilder::builder()
		->setPrivateKey(file_get_contents(CONFIG['merchant_private_key_path']))
		->setPrivateKeyId('4cbcb7a9-481f-4177-a106-7250319feb9b')
		->setProviderPublicKey(file_get_contents(CONFIG['klix_public_key_path']))
		->build();
    $widgetConfigurationSigner = new WidgetConfigurationSigner($apiConfiguration);
    $checkoutWidgetFactory = new CheckoutWidgetFactory($widgetConfigurationSigner);
    $checkoutWidget = $checkoutWidgetFactory->create($widgetConfiguration);
    $htmlRepresentation = $checkoutWidget->getHtmlRepresentation();
    $signatureSource = $widgetConfiguration->toSignatureSource();
	echo "Signature source: <!--$signatureSource-->";
    echo $htmlRepresentation;
}

function addOrderItems($order) {
	$orderItems = json_decode($_POST["orderItems"], true);
	foreach ($orderItems as $orderItemMap) {
		$orderItem = OrderItem::create()
			->setOrderItemId($orderItemMap["orderItemId"])
			->setAmount(floatval($orderItemMap["amount"]))
			->setCurrency($orderItemMap["currency"])
			->setTaxRate(floatval($orderItemMap["taxRate"]))
			->setLabel($orderItemMap["label"])
			->setCount(floatval($orderItemMap["count"]))
			->setUnit($orderItemMap["unit"]);
		$order->addItem($orderItem);
	}
}

function addShippingOptions($order) {
	if ($_POST["shippingMethods"]) {
		$shippingOptions = new ShippingOptions();
		foreach ($_POST["shippingMethods"] as $shippingMethod) {
			$shippingOption = $shippingOptions->getShippingOption($shippingMethod);
			$order->addShippingOption($shippingOption);
		}
	}
}
?>


<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Cart</title>
		<script type="module" src="<?php echo CONFIG['klix_js_lib_module'] ?>"></script>
		<script nomodule="" src="<?php echo CONFIG['klix_js_lib_nomodule'] ?>"></script>
	</head>

	<body>
		<h1>Merchant Site with Klix-Checkout widget</h1>
		<br/>
		<?php printKlixWidget(); ?>
	</body>
</html>
