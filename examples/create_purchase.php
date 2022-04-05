<?php

require_once '../vendor/autoload.php';

$config = include('config.php');

$klix = new \Klix\KlixApi($config['brand_id'], $config['api_key'], $config['endpoint']);

$client = new \Klix\Model\ClientDetails();
$client->email = 'test@example.com';
$purchase = new \Klix\Model\Purchase();
$purchase->client = $client;
$details = new \Klix\Model\PurchaseDetails();
$product = new \Klix\Model\Product();
$product->name = 'Test';
$product->price = 100;
$details->products = [$product];
$purchase->purchase = $details;
$purchase->brand_id = $config['brand_id'];
$purchase->success_redirect = 'https://portal.klix.app/api/v1/?success=1';
$purchase->failure_redirect = 'https://portal.klix.app/api/v1/?success=0';

$result = $klix->createPurchase($purchase);

if ($result && $result->checkout_url) {
	// Redirect user to checkout
	header("Location: " . $result->checkout_url);
	exit;
}