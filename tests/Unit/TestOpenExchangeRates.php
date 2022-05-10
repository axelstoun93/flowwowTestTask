<?php
require_once '../../vendor/autoload.php';

use OpenExchangeRates\OpenExchangeCurlClient;
use OpenExchangeRates\OpenExchangeRates;
use PHPUnit\Framework\TestCase;

class TestOpenExchangeRates extends TestCase {

    public function testLatest(){
        $httpCode = 200;
        $responseBody = file_get_contents('response.json');
        $mockCurlObject = $this->getMockBuilder(OpenExchangeCurlClient::class)
            ->onlyMethods(['sendRequest'])->getMock();
        $mockCurlObject->method('sendRequest')->willReturn([$responseBody, $httpCode]);
        $openExchangeRates = new OpenExchangeRates($mockCurlObject);
        $result = $openExchangeRates->latest('fab7ed8ee6f444ee9389f8fcd20bd549');
        $this->assertIsObject($result);
    }

}
