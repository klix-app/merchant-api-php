<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Klix\Callback\ProviderSignatureValidator;
use Klix\KlixConfigurationBuilder;

define("CONFIG", parse_ini_file("./config_stage.ini"));

$request_body = file_get_contents('php://input');
$decoded = json_decode($request_body);

$signature = getallheaders()["X-Klix-Signature"];
if($signature == null){
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
if($validator->isValid($request_body, $signature)){
    http_response_code(200);
    echo 'Signature validated and payload processed for order ' . $decoded->{'orderId'} . ' of status ' .  $decoded->{'status'};    return;
} else {
    http_response_code(400);
    echo "Invalid signature";

}

//TODO: process callback
