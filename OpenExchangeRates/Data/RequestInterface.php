<?php
namespace OpenExchangeRates\Data;

/**
 * Interface RequestInterface
 */
interface RequestInterface
{
    /**
     * @param array $params
     */
    public function setParams(array $params): void;

    /**
     * @return array
     */
    public function getParams(): array;
}
