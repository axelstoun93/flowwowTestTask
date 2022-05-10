<?php
namespace OpenExchangeRates;

use OpenExchangeRates\Data\RequestInterface;

/**
 * Class OpenExchangeRequest
 */
class OpenExchangeRequest implements RequestInterface
{

    /**
     * @var array
     */
    public array $params;

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $readyParams = [];

        foreach ($params as $key => $value) {
            if (is_null($value)) {
                continue;
            }
            $readyParams[$key] = $value;
        }

        $this->params = $readyParams;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
