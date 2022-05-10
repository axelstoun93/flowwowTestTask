<?php
namespace OpenExchangeRates\Data;

/**
 * Interface ResponseInterface
 */
interface ResponseInterface
{

    /**
     * @return bool
     */
    public function isErrorResponse(): bool;

    /**
     * @return array
     */
    public function getResponse(): array;

    /**
     * @param array $response
     */
    public function setResponse(array $response): void;

    /**
     * @return int
     */
    public function getHttpCode(): int;

    /**
     * @param int $httpCode
     */
    public function setHttpCode(int $httpCode): void;

    /**
     * @return string
     */
    public function getErrorMessage(): string;

}
