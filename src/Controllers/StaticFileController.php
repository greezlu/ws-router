<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Controllers;

use WebServer\Abstracts\ControllerAbstract;
use WebServer\Filesystem\StaticFileManager;
use WebServer\Interfaces\ResultInterface;
use WebServer\Result\File;
use WebServer\Result\Page;
use WebServer\Exceptions\LocalizedException;

/**
 * @package greezlu/ws-router
 */
class StaticFileController extends ControllerAbstract
{
    /**
     * @return File|Page
     */
    public function index(): ResultInterface
    {
        if ($this->request->method !== 'GET') {
            return $this->forward404();
        }

        $staticFileManager = new StaticFileManager();

        $uriComponents = array_splice($this->request->url, 1);
        $filePath = implode('/', $uriComponents);

        if (!$staticFileManager->isFile($filePath)) {
            return $this->forward404();
        }

        try {
            $file = new File($filePath);
        } catch (LocalizedException $error) {
            return $this->forward404();
        }

        $fileName = pathinfo($filePath, PATHINFO_BASENAME);

        header("Content-Disposition: attachment; filename=\"$fileName\"");

        return $file;
    }
}
