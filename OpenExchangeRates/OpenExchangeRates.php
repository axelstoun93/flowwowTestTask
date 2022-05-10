<?php
namespace OpenExchangeRates;

use OpenExchangeRates\Dto\LatestData;
use OpenExchangeRates\Exceptions\OpenExchangeRatesException;

/**
 * Class OpenExchangeRates
 */
class OpenExchangeRates
{

    /**
     * @var OpenExchangeCurlClient
     */
    private OpenExchangeCurlClient $curlClient;

    /**
     * OpenExchangeRates constructor.
     * @param OpenExchangeCurlClient $curlClient
     */
    public function __construct(OpenExchangeCurlClient $curlClient)
    {
        $this->curlClient = $curlClient;
    }

    /**
     * @param string $appId
     * @param string|null $base
     * @param string|null $symbols
     * @param bool|null $prettyPrint
     * @param bool|null $showAlternative
     * @return LatestData
     * @throws OpenExchangeRatesException
     */
    public function latest(
        string $appId,
        string $base = null,
        string $symbols = null,
        bool $prettyPrint = null,
        bool $showAlternative = null
    ): LatestData {
        $request = new OpenExchangeRequest();

        $request->setParams(
            [
                'app_id' => $appId,
                'base' => $base,
                'symbols' => $symbols,
                'prettyprint' => $prettyPrint,
                'show_alternative' => $showAlternative
            ]
        );

        $response = $this->curlClient->call('latest.json', $request);

        if ($response->isErrorResponse()) {
            $this->errorHandler($response->getErrorMessage(), $response->getHttpCode());
        }

        return new LatestData($response->getResponse());
    }


    private function errorHandler($message, $httpCode): void
    {
        $readyMessage = "Error message: $message, HttpCode: $httpCode";
        throw new OpenExchangeRatesException($readyMessage);
    }
}
