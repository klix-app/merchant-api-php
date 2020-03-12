<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Klix\Callback\ProviderSignatureValidator;
use Klix\Callback\ProviderCallbackRequestDecoder;
use Klix\KlixConfigurationBuilder;
use Klix\SignatureValidationFailedException;

define("CONFIG", parse_ini_file("./config_test_env.ini"));

$request_body = file_get_contents('php://input');

$signature = getallheaders()["X-Klix-Signature"];
if ($signature == null) {
    http_response_code(400);
    echo "No signature header present";
    return;
}

$apiConfiguration = KlixConfigurationBuilder::builder()
    ->setPrivateKey(file_get_contents(CONFIG['merchant_private_key_path']))
    ->setPrivateKeyId('4cbcb7a9-481f-4177-a106-7250319feb9b')
    ->setProviderPublicKey(file_get_contents(CONFIG['klix_public_key_path']))
    ->build();

$validator = new ProviderSignatureValidator($apiConfiguration);
$decoder = new ProviderCallbackRequestDecoder($validator);

try {
	$order = $decoder->decodePurchaseFinalizedRequest($request_body, $signature);
	http_response_code(200);
	echo 'Signature validated and payload processed for order ';
	var_dump($order);
} catch (SignatureValidationFailedException $ex) {
	http_response_code(400);
	echo $ex->getMessage();
}

