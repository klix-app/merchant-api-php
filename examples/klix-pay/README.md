# Klix Pay example

## Set up on MacOS

* Navigate to [this directory (examples/klix-pay)](/examples/klix-pay) directory and run ```composer install```
* Create a directory /Users/{YourUserName}/Sites
* Do the following steps from [Apache web-server set-up instructions](https://websitebeaver.com/set-up-localhost-on-macos-high-sierra-apache-mysql-and-php-7-with-sslhttps):
  * Enable php on built-in Apache web-server
  * Set the Apache root path to /Users/{YourUserName}/Sites
* Copy this directory contents to Apache web-server root folder:

```bash
cp -R ./. /Users/{YourUserName}/Sites/klix-pay

```

* Open in the browser <http://localhost/klix-pay/order.php>

## Test purchase complete callback

```bash
curl -X PUT -H "Content-Type: application/json" -H "X-Klix-Signature: BvQ99FrXbvgsdL3MsFlmzV02z6nT1aPfS5NwriqCQv2vZnpxohDVpiJQniVh5su6NyDtBBxWH7xp6EhFENyrAg==" -d\
 '{"id":"97fac169-6fd6-42d5-85ec-46bde2af5114","status":"VERIFIED","customer":{"phone_number":"37122334455"},"payment":{"accountStatementReference":"731560503"},"order_id":"1ab189b7-053d-4b92-969f-7e40b7243aae","tax_amount":0.89,"total_amount":5.12,"items":[{"amount":4.23,"label":"Some product","tax_amount":0.89,"total_amount":5.12,"tax_rate":0.21,"quantity":1.000,"unit":"PIECE","type":"UNKNOWN"}],"currency":"EUR","merchant_urls":{"terms":"https://www.citadele.lv/en/customer-support/terms-for-private-customers/","verification":"https://shop.dev.klix.app/widget/emulator/order/verify","confirmation":"https://shop.dev.klix.app/widget/emulator/payment/complete","place_order":"https://shop.dev.klix.app/emulator/callback"},"effective_amount":5.12}'\
 http://localhost/klix-pay/purchase_complete_callback_handler.php
```
