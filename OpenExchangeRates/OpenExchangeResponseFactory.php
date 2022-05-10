<?php
namespace OpenExchangeRates;

/**
 * Class OpenExchangeResponseFactory
 */
class OpenExchangeResponseFactory
{

    /**
     * @param array $response
     * @param int $httpCode
     * @return OpenExchangeResponse
     */
    public function create(array $response, int $httpCode) :OpenExchangeResponse
    {
        return new OpenExchangeResponse($response, $httpCode);
    }

}
