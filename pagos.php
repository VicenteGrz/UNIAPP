<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure Bearer authorization: bearerAuth
$config = DigitalFemsa\Configuration::getDefaultConfiguration()->setAccessToken('key_MDOXvqHIPwFZw5TD9BME9aG');


$apiInstance = new DigitalFemsa\Api\ApiKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$api_key_request = new \DigitalFemsa\Model\ApiKeyRequest(); // \DigitalFemsa\Model\ApiKeyRequest | requested field for a api keys
$accept_language = "es"; // string | Use for knowing which language to use
$x_child_company_id = "6441b6376b60c3a638da80af"; // string | In the case of a holding company, the company id of the child company to which will process the request.

try {
    $result = $apiInstance->createApiKey($api_key_request, $accept_language, $x_child_company_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ApiKeysApi->createApiKey: ', $e->getMessage(), PHP_EOL;
}
