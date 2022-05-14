<?php
require_once 'vendor/autoload.php';

use OpenExchangeRates\OpenExchangeCurlClient;
use OpenExchangeRates\OpenExchangeRates;

try {
    $openExchangeRates = new OpenExchangeRates(new OpenExchangeCurlClient());
    $result  = $openExchangeRates->latest('fab7ed8ee6f444ee9389f8fcd20bd549');
    $resultHistorical = $openExchangeRates->historical('1999-11-28','fab7ed8ee6f444ee9389f8fcd20bd549');
    echo $result->rates->RUB.' / '.$resultHistorical->rates->RUB.'(1999-11-28)';

}catch (Exception $exception){
    echo $exception->getMessage();
}
