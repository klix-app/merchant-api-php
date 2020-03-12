<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Klix\KlixConfigurationBuilder;
use Klix\Widget\CheckoutWidgetFactory;
use Klix\Widget\Order;
use Klix\Widget\OrderItem;
use Klix\Widget\WidgetConfiguration;
use Klix\Widget\WidgetConfigurationSigner;

define("CONFIG", parse_ini_file("./config_test_env.ini"));

function printKlixWidget()
{

    $apiConfiguration = KlixConfigurationBuilder::builder()
        ->setPrivateKey(file_get_contents(CONFIG['merchant_private_key_path']))
        ->setPrivateKeyId('4cbcb7a9-481f-4177-a106-7250319feb9b')
        ->setProviderPublicKey(file_get_contents(CONFIG['klix_public_key_path']))
        ->build();

    $orderItem = OrderItem::create()
        ->setAmount($_POST["price"])
        ->setCurrency($_POST["currency"])
        ->setLabel($_POST["label"]);
    $order = Order::create()
        ->setOrderId($_POST["orderId"])
        ->addItem($orderItem);
    $widgetConfiguration = WidgetConfiguration::create()
        ->setWidgetId(CONFIG['widget_id'])
        ->setLanguage($_POST["language"])
        ->setOrder($order);

    $widgetConfigurationSigner = new WidgetConfigurationSigner($apiConfiguration);
    $checkoutWidgetFactory = new CheckoutWidgetFactory($widgetConfigurationSigner);
    $checkoutWidget = $checkoutWidgetFactory->create($widgetConfiguration);
    $htmlRepresentation = $checkoutWidget->getHtmlRepresentation();

    echo $htmlRepresentation;
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
		<h1>Merchant Site with Klix-Pay widget</h1>
		<br/>
		<?php printKlixWidget(); ?>
	</body>
</html>
