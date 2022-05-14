<?php
namespace OpenExchangeRates\Dto\Entity;
use OpenExchangeRates\Dto\DataTransferObject;

/**
 * Class Meta
 */
class Meta extends DataTransferObject
{
    /**
     * @var int
     */
    public int $timestamp;
    /**
     * @var float
     */
    public float $rate;
}
