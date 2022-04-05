<?php

require_once '../vendor/autoload.php';

$config = include('config.php');

$klix = new \Klix\KlixApi($config['brand_id'], $config['api_key'], $config['endpoint']);

$methods = $klix->getPaymentMethods('EUR');

print json_encode($methods);