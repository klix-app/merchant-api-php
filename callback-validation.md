# Order authorization using merchant's callback

Besides order authorization using order signature provided by merchant Klix supports another order authorization method using merchant's callback.

## Library usage

### Create and configure API client instance

Merchant order authorization via callback requires three additional fiels to be set on `KlixConfiguration`: API base URL, API key and merchant identifier.

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Klix\KlixConfigurationBuilder;
use Klix\KlixConfiguration;
use Klix\ApiClient;
use Klix\Merchant\MerchantApi;

$klixConfiguration = KlixConfigurationBuilder::builder()
    ->setBaseUri(KlixConfiguration::TEST_BASE_URL)
    ->setApiKey('52a49f81-0869-40a6-8dde-96a624e61b54')
    ->setMerchantId('f6cef80b-92a4-4bc2-b611-7dc597f9ba60')
    ->setPrivateKey(file_get_contents('resources/keys/merchant_private_key.pem'))
    ->setPrivateKeyId('52a49f81-0869-40a6-8dde-96a624e61b54')
    ->setProviderPublicKey(file_get_contents('resources/keys/provider_public_key.pem'))
    ->setDebugEnabled(true)
    ->build();

$apiClient = new ApiClient(
	$klixConfiguration,
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
use Klix\Merchant\RequestDecoder;

$requestBodyString = //obtain request body
$orderVerificationRequest = RequestDecoder::decodeOrderVerificationRequest($requestBodyString, $apiConfiguration);
$orderId = $orderVerificationRequest.getOrderId();
?>
```

### Retrieve order details

Order verification request contains only order identified. Full order details can be retrieved before confirming/rejecting on order.

```php
<?php
use Klix\ApiException;

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
use Klix\ApiException;

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
use Klix\Merchant\OrderRejection;

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
use Klix\Merchant\RequestDecoder;

$requestBodyString = //obtain request body
$purchaseFinalizedNotificationRequest = RequestDecoder::decodePurchaseFinalizedNotificationRequest($requestBodyString, $apiConfiguration);
$orderId = $purchaseFinalizedNotificationRequest.getOrderId();
?>
```
