<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Abstracts;

use WebServer\Controllers\ErrorController;
use WebServer\Interfaces\ControllerInterface;
use WebServer\Interfaces\ResultInterface;
use WebServer\Result\Page;
use WebServer\Core\Request;

/**
 * @package greezlu/ws-router
 */
abstract class ControllerAbstract implements ControllerInterface
{
    protected const TEMPLATE_FILE = null;

    protected const CONTENT_FILE = null;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @param Request $request
     */
    public function __construct(
        Request $request
    ) {
        $this->request = $request;
    }

    public function index(): ResultInterface
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error404();
    }

    public function create(): ResultInterface
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error404();
    }

    public function store(): ResultInterface
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error404();
    }

    public function show(): ResultInterface
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error404();
    }

    public function edit(): ResultInterface
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error404();
    }

    public function update(): ResultInterface
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error404();
    }

    public function destroy(): ResultInterface
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error404();
    }

    /**
     * @return Page
     */
    protected function forward500(): Page
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error500();
    }

    /**
     * @return Page
     */
    protected function forward404(): Page
    {
        $errorController = new ErrorController($this->request);
        return $errorController->error404();
    }
}
