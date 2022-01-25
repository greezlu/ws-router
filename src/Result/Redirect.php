<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Result;

use WebServer\Interfaces\ResultInterface;

/**
 * @package greezlu/ws-router
 */
class Redirect implements ResultInterface
{
    /**
     * @var string
     */
    private string $path;

    /**
     * @var int
     */
    private int $responseCode;

    /**
     * @param string|null $path
     * @param int|null $responseCode
     */
    public function __construct(
        string $path = null,
        int $responseCode = 302
    ) {
        $this->path = $path ?? filter_input(INPUT_SERVER, 'HTTP_REFERER') ?: '/';
        $this->responseCode = $responseCode;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        http_response_code($this->responseCode);
        header("Location: " . $this->path);
    }
}
