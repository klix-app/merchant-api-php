<?php

require_once '../vendor/autoload.php';

$config = include('config.php');

$klix = new \Klix\KlixApi($config['brand_id'], $config['api_key'], $config['endpoint']);

$purchase_id = '999cce79-0e81-491a-b418-1779c88e6662';

$purchase = $klix->getPurchase($purchase_id);

//$refund = $klix->refundPurchase($purchase_id);

//$cancel = $klix->cancelPurchase($purchase_id);

//$release = $klix->releasePurchase($purchase_id);

//$capture = $klix->capturePurchase($purchase_id);

//$charge = $klix->chargePurchase($purchase_id, 'test');

//$deleteToken = $klix->deleteRecurringToken($purchase_id);

print json_encode($purchase);