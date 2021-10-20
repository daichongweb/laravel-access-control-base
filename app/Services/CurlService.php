<?php

namespace App\Services;

use App\Exceptions\ApiException;
use Curl\Curl;

/**
 * curl请求封装
 */
class CurlService
{
    private $url;

    private $curl;

    private $data;

    private $json = false;

    private $toArray = true;

    private $method = 'post';

    private $headers;

    public function __construct()
    {
        $this->curl = new Curl();
    }

    /**
     * @throws ApiException
     */
    public function request()
    {
        $_method = $this->getMethod();
        $this->setCurlHeader();
        $this->curl->$_method($this->getUrl(), $this->getData(), $this->isJson());
        if ($this->curl->error) {
            throw new ApiException($this->curl->error_message);
        }
        return $this->response();
    }

    private function response()
    {
        if ($this->isToArray()) {
            return json_decode($this->curl->response, true);
        }
        return $this->curl->response;
    }

    private function setCurlHeader()
    {
        if ($headers = $this->getHeaders()) {
            foreach ($headers as $key => $header) {
                $this->curl->setHeader($key, $header);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): CurlService
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): CurlService
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return bool
     */
    public function isJson(): bool
    {
        return $this->json;
    }

    /**
     * @param bool $isJson
     */
    public function setIsJson(bool $isJson): CurlService
    {
        $this->json = $isJson;
        return $this;
    }

    /**
     * @return bool
     */
    public function isToArray(): bool
    {
        return $this->toArray;
    }

    /**
     * @param bool $toArray
     */
    public function setToArray(bool $toArray): CurlService
    {
        $this->toArray = $toArray;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): CurlService
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers): CurlService
    {
        $this->headers = $headers;
        return $this;
    }
}
