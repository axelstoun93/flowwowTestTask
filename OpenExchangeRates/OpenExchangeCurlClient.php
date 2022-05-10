<?php
namespace OpenExchangeRates;

use OpenExchangeRates\Exceptions\OpenExchangeCurlException;

/**
 * Class OpenExchangeCurlClient
 */
class OpenExchangeCurlClient
{

    /**
     * @var OpenExchangeResponseFactory
     */
    private OpenExchangeResponseFactory $openExchangeResponseFactory;

    /**
     * @var array
     */
    private array $defaultHeaders = [
        'Content-Type' => 'application/json; charset=utf-8',
        'Accept' => 'application/json',
    ];

    /**
     * @var
     */
    private $curl;

    /**
     * @var int
     */
    private int $timeout = 80;

    /**
     * @var int
     */
    private int $connectionTimeout = 30;

    /**
     * @var string
     */
    private string $url = 'https://openexchangerates.org/api/';

    /**
     * OpenExchangeCurlClient constructor.
     */
    public function __construct()
    {
        $this->openExchangeResponseFactory = new OpenExchangeResponseFactory();
    }

    /**
     * @param string $path
     * @param OpenExchangeRequest $request
     * @param array $headers
     * @return OpenExchangeResponse
     */
    public function call(string $path, OpenExchangeRequest $request, array $headers = []): OpenExchangeResponse
    {
        $headers = $this->prepareHeaders($headers);

        $url = $this->prepareUrl($path);

        $this->prepareCurl($request, $this->implodeHeaders($headers), $url);

        list($response,$httpCode) = $this->sendRequest();

        $this->closeCurlConnection();

        return $this->openExchangeResponseFactory->create($this->decodeData($response), $httpCode);
    }


    /**
     * @param string $response
     * @return array
     */
    public function decodeData(string $response): array
    {
        return json_decode($response, true);
    }


    /**
     * @return array
     * @throws OpenExchangeCurlException
     */
    public function sendRequest(): array
    {
        $response = curl_exec($this->curl);
        $responseInfo = curl_getinfo($this->curl);
        $curlError = curl_error($this->curl);
        $curlErrno = curl_errno($this->curl);
        if ($response === false) {
            $this->handleCurlError($curlError, $curlErrno);
        }

        return [$response,$responseInfo['http_code']];
    }


    /**
     * @param array $headers
     * @return array
     */
    private function prepareHeaders(array $headers): array
    {
        $headers = array_merge($this->defaultHeaders, $headers);
        return $headers;
    }

    /**
     * @param array $headers
     * @return array
     */
    private function implodeHeaders(array $headers): array
    {
        return array_map(
            function ($key, $value) {
                return $key . ':' . $value;
            },
            array_keys($headers),
            $headers
        );
    }

    /**
     * @param $optionName
     * @param $optionValue
     * @return bool
     */
    public function setCurlOption($optionName, $optionValue)
    {
        return curl_setopt($this->curl, $optionName, $optionValue);
    }

    /**
     * @return false|resource
     */
    private function initCurl()
    {
        if (!extension_loaded('curl')) {
            throw new OpenExchangeCurlException('curl error');
        }

        $this->curl = curl_init();

        return $this->curl;
    }

    /**
     *
     */
    public function closeCurlConnection(): void
    {
        if ($this->curl !== null) {
            curl_close($this->curl);
        }
    }

    /**
     * @param $path
     * @return string
     */
    private function prepareUrl($path): string
    {
        return $this->getUrl() . $path;
    }

    /**
     * @return string
     */
    private function getUrl(): string
    {
        return $this->url;
    }


    /**
     * @param OpenExchangeRequest $request
     * @param $headers
     * @param $url
     */
    private function prepareCurl(OpenExchangeRequest $request, array $headers, string $url): void
    {
        $this->initCurl();

        $this->setParamUrl($url, $request->getParams());

        $this->setCurlOption(CURLOPT_URL, $url);

        $this->setCurlOption(CURLOPT_RETURNTRANSFER, true);

        $this->setCurlOption(CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);

        $this->setCurlOption(CURLOPT_TIMEOUT, $this->timeout);
    }

    /**
     * @param $url
     * @param array $params
     */
    public function setParamUrl(&$url, array $params): void
    {
        $url = $url . '?' . http_build_query($params);
    }


    /**
     * @param $error
     * @param $errno
     * @throws OpenExchangeCurlException
     */
    private function handleCurlError($error, $errno): void
    {
        switch ($errno) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $msg = 'Could not connect to api openexchangerates.org. Please check your internet connection and try again.';
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                $msg = 'Could not verify SSL certificate.';
                break;
            default:
                $msg = 'Unexpected error communicating.';
        }
        $msg .= "\n\n(Network error [errno $errno]: $error)";
        throw new OpenExchangeCurlException($msg);
    }
}
