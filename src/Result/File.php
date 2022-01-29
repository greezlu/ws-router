<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Result;

use WebServer\Exceptions\LocalizedException;
use WebServer\Filesystem\PubFileManager;
use WebServer\Interfaces\ResultInterface;

/**
 * @package greezlu/ws-router
 */
class File implements ResultInterface
{
    /**
     * @var string
     */
    private string $filePath;

    /**
     * @var PubFileManager
     */
    private PubFileManager $pubFileManager;

    /**
     * @param string $filePath
     * @throws LocalizedException
     */
    public function __construct(
        string $filePath
    ) {
        $this->pubFileManager = new PubFileManager();

        if (!$this->pubFileManager->isFile($filePath)) {
            throw new LocalizedException('Unable to find file: '. $filePath);
        }

        $this->filePath = $filePath;
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $filePath = $this->filePath;

        if ($this->pubFileManager->isFile($filePath)) {
            $this->pubFileManager->openFile($filePath);
        } else {
            throw new LocalizedException('Unable to locate file: ' . $filePath);
        }
    }
}
