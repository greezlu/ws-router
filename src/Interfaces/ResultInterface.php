<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Interfaces;

/**
 * @package greezlu/ws-router
 */
interface ResultInterface
{
    /**
     * Result main function.
     *
     * @return void
     */
    public function execute(): void;
}
