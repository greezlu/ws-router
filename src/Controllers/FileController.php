<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Greezlu\Controllers;

use WebServer\Abstracts\ControllerAbstract;
use WebServer\Interfaces\ResultInterface;
use WebServer\Result\File;
use WebServer\Result\Page;
use WebServer\Exceptions\LocalizedException;

/**
 * @package greezlu/ws-router
 */
class FileController extends ControllerAbstract
{
    /**
     * @return File|Page
     */
    public function index(): ResultInterface
    {
        $filePath = $this->request->postParams['file_path'] ?? null;

        if (is_null($filePath)) {
            return $this->forward404();
        }

        $fileName = pathinfo($filePath, PATHINFO_BASENAME);

        try {
            $file = new File($filePath);
        } catch (LocalizedException $error) {
            return $this->forward404();
        }

        header("Content-Disposition: attachment; filename=\"$fileName\"");
        return $file;
    }
}
