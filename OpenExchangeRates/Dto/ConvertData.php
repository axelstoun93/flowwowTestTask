<?php
namespace OpenExchangeRates\Dto;

use OpenExchangeRates\Dto\Entity\Meta;
use OpenExchangeRates\Dto\Entity\Request;

/**
 * Class ConvertData
 */
class ConvertData extends DataTransferObject
{
    /**
     * @var string
     */
    public string $disclaimer;
    /**
     * @var string
     */
    public string $license;

    /**
     * @var Request
     */
    public Request $request;

    /**
     * @var Meta
     */
    public Meta $meta;

    /**
     * @var float
     */
    public float $response;

}
