<?php
namespace OpenExchangeRates;

use OpenExchangeRates\Data\ResponseInterface;

/**
 * Class OpenExchangeResponse
 */
class OpenExchangeResponse implements ResponseInterface {

    /**
     * @var int
     */
    private int $httpCode;

    /**
     * @var array
     */
    private array $response;

    /**
     * OpenExchangeResponse constructor.
     * @param array $response
     * @param int $httpCode
     */
    public function __construct(array $response, int $httpCode)
    {
        $this->httpCode = $httpCode;
        $this->response = $response;
    }


    /**
     * @return bool
     */
    public function isErrorResponse(): bool
    {
        return $this->httpCode !== 200;
    }

    /**
     * @param int $httpCode
     */
    public function setHttpCode(int $httpCode): void
    {
        $this->httpCode = $httpCode;
    }

    /**
     * @param array $response
     */
    public function setResponse(array $response): void
    {
        $this->response = $response;
    }


    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }


    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }


    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        if (isset($this->response['message'])) {
            return (string)$this->response['message'];
        }
        return '';
    }
}
