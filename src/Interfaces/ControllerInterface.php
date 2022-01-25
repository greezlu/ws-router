<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Interfaces;

use WebServer\Core\Request;

/**
 * @package greezlu/ws-router
 */
interface ControllerInterface
{
    public function __construct(Request $request);

    public function index(): ResultInterface;

    public function create(): ResultInterface;

    public function store(): ResultInterface;

    public function show(): ResultInterface;

    public function edit(): ResultInterface;

    public function update(): ResultInterface;

    public function destroy(): ResultInterface;
}
