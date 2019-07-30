# Klix.app Merchant API PHP client library

## Requirements

PHP 5.5 and later

## Installation
### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/klix-app/merchant-api-php.git"
    }
  ],
  "require": {
    "klix/merchant-api-php": "*@dev"
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


### Create and configure API client instance

`ApiConfiguration` class represents Klix API configuration. Values for configuration properties and merchant's private / service provider's public keys can be accessed on Klix Merchant Console site. 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiConfiguration = ApiConfigurationBuilder::builder()
    ->setBaseUri(ApiConfiguration::TEST_BASE_URL)
    ->setApiKey('52a49f81-0869-40a6-8dde-96a624e61b54')
    ->setMerchantId('f6cef80b-92a4-4bc2-b611-7dc597f9ba60')
    ->setPrivateKey(file_get_contents('resources/keys/merchant_private_key.pem'))
    ->setPrivateKeyId('52a49f81-0869-40a6-8dde-96a624e61b54')
    ->setProviderPublicKey(file_get_contents('resources/keys/provider_public_key.pem'))
    ->setDebugEnabled(true)
    ->build();

$apiClient = new ApiClient(
	$apiConfiguration,
	// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

$merchantApi = new MerchantApi($apiClient);
?>
```

### Receive order verification request
After Klix user has confirmed an order but before his card has been charged Klix back-end will send a signed order validation request that should be handled by merchant internet shop. Request body will contain signed request details that needs to be decoded. 

```php
<?php
$requestBodyString = //obtain request body
$orderVerificationRequest = RequestDecoder::decodeOrderVerificationRequest($requestBodyString, $apiConfiguration);
$orderId = $orderVerificationRequest.getOrderId();
?>
```

### Retrieve order details
Order verification request contains only order identified. Full order details can be retrieved before confirming/rejecting on order.
```php
<?php
try {
    $order = $merchantApi->getOrder($order_id);
    print_r($result);
} catch (ApiException $e) {
    echo 'Exception when calling MerchantApi->getOrder: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Verify or reject order
Retrieved order contains both information about customer and products included in order. Merchant should at least validate products prices and availability and perform additional validations if needed.
If verification is successful Klix verify order API end-point should be called.
```php
<?php
try {
    $merchantApi->verifyOrder($order);
} catch (ApiException $e) {
    echo 'Exception when calling MerchantApi->verifyOrder: ', $e->getMessage(), PHP_EOL;
}
?>
```
If there are any issues during order verification order can be rejected. When rejecting an order rejection reason should be specified. 
```php
<?php
try {
	$orderRejection = new OrderRejection('Out of stock');
    $merchantApi->rejectOrder($orderId, $orderRejection);
} catch (ApiException $e) {
    echo 'Exception when calling MerchantApi->rejectOrder: ', $e->getMessage(), PHP_EOL;
}
?>
```
### Receive purchase completed callback
Upon purchase completion Klix back-end will send purchase completed callback to merchant's internet shop. 
```php
<?php
$requestBodyString = //obtain request body
$purchaseFinalizedNotificationRequest = RequestDecoder::decodePurchaseFinalizedNotificationRequest($requestBodyString, $apiConfiguration);
$orderId = $purchaseFinalizedNotificationRequest.getOrderId();
?>
```

## Author

developers@klix.app

