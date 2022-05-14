<?php
namespace OpenExchangeRates\Dto\Entity;
use OpenExchangeRates\Dto\DataTransferObject;

/**
 * Class Request
 */
class Request extends DataTransferObject
{

    /**
     * @var string
     */
    public string $query;

    /**
     * @var float
     */
    public float $amount;

    /**
     * @var string
     */
    public string $from;

    /**
     * @var string
     */
    public string $to;
}
