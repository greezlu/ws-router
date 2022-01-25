<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Result;

use WebServer\Exceptions\LocalizedException;
use WebServer\Filesystem\FileManager;
use WebServer\Interfaces\ResultInterface;

/**
 * @package greezlu/ws-router
 */
class File implements ResultInterface
{
    protected const FILE_DIRECTORY = 'files';

    /**
     * @var string
     */
    private string $filePath;

    /**
     * @var FileManager
     */
    private FileManager $fileManager;

    /**
     * @param string $filePath
     * @throws LocalizedException
     */
    public function __construct(
        string $filePath
    ) {
        $this->fileManager = new FileManager();
        $this->filePath = $filePath;
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $filePath = static::FILE_DIRECTORY  . '/' . $this->filePath;

        if ($this->fileManager->isFile($filePath)) {
            $this->fileManager->openFile($filePath);
        } else {
            throw new LocalizedException('Unable to locate file: ' . $filePath);
        }
    }
}
