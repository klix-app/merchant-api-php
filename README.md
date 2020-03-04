# Klix.app Merchant API PHP client library

## Requirements

PHP 5.5 and later

## Installation

### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```json
{
  "require": {
    "klix-app/merchant-api-php": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
require_once('/path/to/merchant-api-php/vendor/autoload.php');
```

## Library usage

### Create Klix integration configuration

`KlixConfiguration` class represents Klix integration configuration. Values for configuration properties and merchant's private / service provider's public keys can be found on Klix Merchant Console site.

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Klix\KlixConfigurationBuilder;

$apiConfiguration = KlixConfigurationBuilder::builder()
    ->setPrivateKey(file_get_contents('resources/keys/merchant_private_key.pem'))
    ->setPrivateKeyId('52a49f81-0869-40a6-8dde-96a624e61b54')
    ->setProviderPublicKey(file_get_contents('resources/keys/provider_public_key.pem'))
    ->build();
?>
```

### Create widget configuration

`WidgetConfiguration` class represents widget and order configuration. 
In order to construct proper `WidgetConfiguration` at least widget identifier, language and order with single order item should be passed.
Single order item in this case is used to represent order total amount even if order shopping cart consists of multiple products.

```php
<?php
$orderItem = OrderItem::create()
    ->setAmount(120.04)
    ->setCurrency('EUR')
    ->setLabel("Order No 1234567890");
$order = Order::create()
    ->setOrderId("36c420f4-5487-11ea-a2e3-2e728ce88125")
    ->addItem($orderItem);
$widgetConfiguration = WidgetConfiguration::create()
    ->setWidgetId("d700a786-56da-11ea-8e2d-0242ac130003")
    ->setLanguage("lv")
    ->setOrder($order);
?>
```

Multiple order items can be specified to represent all products and their quantities included in this order.
Additionally to that available shipping options and card acceptance constraints can be specified.  

```php
<?php
$firstOrderItem = OrderItem::create()
    ->setAmount(122.99)
    ->setCount(2)
    ->setCurrency("EUR")
    ->setLabel("Vacuum cleaner TC31")
    ->setOrderItemId("ff713414-56f9-11ea-82b4-0242ac130003")
    ->setTaxRate(0.21)
    ->setUnit("PIECE");
$secondOrderItem = OrderItem::create()
    ->setAmount(7.05)
    ->setCurrency('EUR')
    ->setLabel("Filter for TC31");
$firstShippingOption = ShippingOption::create()
    ->setId("courier")
    ->setAmount(3);
$secondShippingOption = ShippingOption::create()
    ->setId("pickup")
    ->setTitle("In store pickup")
    ->setAmount(0)
    ->setCurrency("EUR");
$constraints = new OrderConstraints();
$constraints->setBrand("Citadele");
$order = Order::create()
    ->setOrderId("1234567890")
    ->addItem($firstOrderItem)
    ->addItem($secondOrderItem)
    ->addShippingOption($firstShippingOption)
    ->addShippingOption($secondShippingOption)
    ->setConstraints($constraints);
$widgetConfiguration = WidgetConfiguration::create()
    ->setWidgetId("d700a786-56da-11ea-8e2d-0242ac130003")
    ->setLanguage("lv")
    ->setCertificateName("6af6c4fc-56db-11ea-8e2d-0242ac130003")
    ->setOrder($order);
?>
```

### Generate widget HTML representation

In order to include Klix widget HTML to merchant web-page `CheckoutWidget` class instance should be obtained from `CheckoutWidgetFactory`.

```php
<?php
$widgetConfigurationSigner = new WidgetConfigurationSigner($apiConfiguration);
$checkoutWidgetFactory = new CheckoutWidgetFactory($widgetConfigurationSigner);
$checkoutWidget = $checkoutWidgetFactory->create($widgetConfiguration);
$htmlRepresentation = $checkoutWidget->getHtmlRepresentation();
echo $htmlRepresentation;
?>
```

Previous example will print Klix widget HTML similar to:

```html
<klix-checkout
    widget-id="d700a786-56da-11ea-8e2d-0242ac130003"
    language="lv"
    certificate-name="6af6c4fc-56db-11ea-8e2d-0242ac130003"
    signature="T2mN980RRnm6eTmnggYNA51RkZ/NItnPF2H4Z/c92gyBM2MuX/u8KVuQsdBlt9XDUfFq6HA2sXIr1cNWzUrTV51VHsuq5u17aTZ4a1rWPjdegjfVVI0ErIDXKrEHzvS1PJ0VvyFUBeZEQEXWTMyRGfCTgO8/pDWbEfwTXeY8HzqftaGj00ej5/upGHhVn2SDVtGsp55I7uW/PIRUWCnxxZKwA/VzALUlTGgCGoxE9fhBiFVcOVPSi0sLUReL1yw21gRWLg/uMx6tuNHK25fvtLzVLO6MigOruA5mFfT3jnHHczrkpjOeOJ+FwZ1mmkCOyCdPYC0G8CCF8C5EYBr4dA=="
    order="{&quot;orderId&quot;:&quot;36c420f4-5487-11ea-a2e3-2e728ce88125&quot;,&quot;items&quot;:[{&quot;amount&quot;:122.99,&quot;currency&quot;:&quot;EUR&quot;,&quot;label&quot;:&quot;Vacuum cleaner TC31&quot;,&quot;count&quot;:2,&quot;unit&quot;:&quot;PIECE&quot;,&quot;taxRate&quot;:0.21,&quot;orderItemId&quot;:&quot;ff713414-56f9-11ea-82b4-0242ac130003&quot;},{&quot;amount&quot;:7.05,&quot;currency&quot;:&quot;EUR&quot;,&quot;label&quot;:&quot;Filter for TC31&quot;,&quot;count&quot;:null,&quot;unit&quot;:null,&quot;taxRate&quot;:null,&quot;orderItemId&quot;:null}],&quot;shippingOptions&quot;:[{&quot;id&quot;:&quot;courier&quot;,&quot;amount&quot;:3,&quot;currency&quot;:null,&quot;taxRate&quot;:null,&quot;title&quot;:null,&quot;excludeFromOrderIfFree&quot;:null},{&quot;id&quot;:&quot;pickup&quot;,&quot;amount&quot;:0,&quot;currency&quot;:&quot;EUR&quot;,&quot;taxRate&quot;:null,&quot;title&quot;:&quot;In store pickup&quot;,&quot;excludeFromOrderIfFree&quot;:null}],&quot;constraints&quot;:{&quot;paymentScheme&quot;:null,&quot;issuer&quot;:null,&quot;brand&quot;:&quot;Citadele&quot;}}">
</klix-checkout>
```

Note that Klix widget JavaScript should be loaded in order to properly render Klix widget web component. See [Klix quick start guide](https://developers.klix.app/quick-start-guide/#1-embed-klix-widget-into-your-web-shop).

### Receive purchase completed callback

Upon purchase completion Klix back-end will send purchase completed callback to merchant's website. At that moment merchants web-shop should update order status according to payment status.

```php
<?php
use Klix\Callback\ProviderSignatureValidator;
use Klix\Callback\ProviderCallbackRequestDecoder;

$requestBodyString = // read request body
$signature = // read request header "X-Klix-Signature" value 
$validator = new ProviderSignatureValidator($apiConfiguration);
$decoder = new ProviderCallbackRequestDecoder($validator);

$merchantOrder = $decoder->decodePurchaseFinalizedRequest($requestBodyString, $signature);

echo $merchantOrder->getId();
echo $merchantOrder->getStatus();

?>
```

## Other order authorization method

Besides order authorization using order signature provided by merchant Klix supports another order authorization method using merchant's [callback](callback-validation.md) for more advanced use cases.

## Running tests

Check out library [unit tests](test/Klix) for more examples of Klix PHP library API usage. Command to execute all tests:

```bash
composer unit
```

## About

### License

Klix.app Merchant API PHP client library is licensed under the Apache 2.0 License - see the `LICENSE` file for details

### Author

developers@klix.app
