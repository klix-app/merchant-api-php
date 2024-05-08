<?php

require_once '../vendor/autoload.php';

$config = include('config.php');

$klix = new \Klix\KlixApi($config['brand_id'], $config['api_key'], $config['endpoint']);

$client = new \Klix\Model\ClientDetails();
$client->email = 'test@example.com';
$purchase = new \Klix\Model\Purchase();
$purchase->client = $client;
$details = new \Klix\Model\PurchaseDetails();
$paymentToFirstIbanProduct = new \Klix\Model\Product();
$paymentToFirstIbanProduct->name = 'Payment to first IBAN';
$paymentToFirstIbanProduct->price = 100;
$paymentToSecondIbanProduct = new \Klix\Model\Product();
$paymentToSecondIbanProduct->name = 'Payment to second IBAN';
$paymentToSecondIbanProduct->price = 200;
$details->products = [$paymentToFirstIbanProduct, $paymentToSecondIbanProduct];
$paymentMethodDetails = new \Klix\Model\PaymentMethodDetails();
$firstCreditor = new \Klix\Model\PisBulkPurchase();
$firstCreditor->creditor_name = 'John Doe';
$firstCreditor->creditor_iban = 'LVXXPARX0000000000001';
$secondCreditor = new \Klix\Model\PisBulkPurchase();
$secondCreditor->creditor_name = 'Jane Doe';
$secondCreditor->creditor_iban = 'LVXXHABA0000000000001';
$paymentMethodDetails->pis_bulk_purchase = [$firstCreditor, $secondCreditor];
$details->payment_method_details = $paymentMethodDetails;
$purchase->purchase = $details;
$purchase->brand_id = $config['brand_id'];
$purchase->payment_method_whitelist = ['swedbank_lv_pis'];
$purchase->success_redirect = 'https://portal.klix.app/api/v1/?success=1';
$purchase->failure_redirect = 'https://portal.klix.app/api/v1/?success=0';

$result = $klix->createPurchase($purchase);

if ($result && $result->checkout_url) {
	print($result->checkout_url);
	print('\n');
	// Redirect user to checkout
	header("Location: " . $result->checkout_url);
	exit;
}
