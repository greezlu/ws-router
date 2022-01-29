<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Controllers;

use WebServer\Abstracts\ControllerAbstract;
use WebServer\Result\Page;

/**
 * @package greezlu/ws-router
 */
class ErrorController extends ControllerAbstract
{
    protected const TEMPLATE_FILE = 'main';

    protected const CONTENT_FILE = 'error';

    /**
     * Get error 404 page.
     *
     * @return Page
     */
    public function error404(): Page
    {
        try {
            $page = new Page(
                static::TEMPLATE_FILE,
                static::CONTENT_FILE . '/' . __FUNCTION__
            );
            http_response_code(404);
            return $page;
        } catch (\Exception $error) {
            return $this->error500();
        }
    }

    /**
     * Get error 500 page.
     *
     * @return Page
     */
    public function error500(): Page
    {
        http_response_code(500);

        try {
            return new Page(
                static::TEMPLATE_FILE,
                static::CONTENT_FILE . '/' . __FUNCTION__
            );
        } catch (\Exception $error) {
            exit();
        }
    }

    /**
     * @return Page
     */
    public function forward500(): Page
    {
        return $this->error500();
    }

    /**
     * @return Page
     */
    public function forward404(): Page
    {
        return $this->error404();
    }
}
