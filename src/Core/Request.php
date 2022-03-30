<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Core;

/**
 * @package greezlu/ws-router
 */
class Request
{
    protected const METHOD_LIST = [
        'GET',
        'POST',
        'PUT',
        'DELETE'
    ];

    /**
     * @var array
     */
    public array $url;

    /**
     * @var string
     */
    public string $method;

    /**
     * @var array
     */
    public array $getParams;

    /**
     * @var array
     */
    public array $postParams;

    /**
     * @var array
     */
    public array $cookie;

    /**
     * @var array
     */
    public array $files;

    /**
     * Request constructor
     */
    public function __construct()
    {
        $this->url          = $this->getRequestUrl();
        $this->getParams    = $this->getRequestParamsGet();
        $this->postParams   = $this->getRequestParamsPost();
        $this->cookie       = $this->getRequestCookie();
        $this->files        = $this->getRequestFiles();
        $this->method       = $this->getRequestMethod();
    }

    /**
     * @return array
     */
    protected function getRequestUrl(): array
    {
        $url = parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI') ?: '/')['path'];
        $url = trim($url, '/');

        return explode('/', $url) ?: [];
    }

    /**
     * @return array
     */
    protected function getRequestParamsGet(): array
    {
        return filter_input_array(INPUT_GET) ?: [];
    }

    /**
     * @return array
     */
    protected function getRequestParamsPost(): array
    {
        return filter_input_array(INPUT_POST) ?: [];
    }

    /**
     * @return array
     */
    protected function getRequestCookie(): array
    {
        return filter_input_array(INPUT_COOKIE) ?: [];
    }

    /**
     * @return array
     */
    protected function getRequestFiles(): array
    {
        return $_FILES ?: [];
    }

    /**
     * @return string
     */
    protected function getRequestMethod(): string
    {
        $postParamsMethod = $this->postParams['method'] ?? null;

        $method = in_array($postParamsMethod, static::METHOD_LIST)
            ? $postParamsMethod
            : filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        return $method ?: static::METHOD_LIST[0];
    }
}
