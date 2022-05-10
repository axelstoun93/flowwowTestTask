<?php
namespace OpenExchangeRates\Dto;

use OpenExchangeRates\Dto\Entity\Rates;

/**
 * Class LatestData
 */
class LatestData extends DataTransferObject {
    /**
     * @var string
     */
    public string $disclaimer;
    /**
     * @var string
     */
    public string $license;
    /**
     * @var int
     */
    public int $timestamp;
    /**
     * @var string
     */
    public string $base;
    /**
     * @var Rates
     */
    public Rates $rates;
}
