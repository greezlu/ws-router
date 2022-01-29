<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Result;

use WebServer\Interfaces\ResultInterface;
use WebServer\Core\Config;
use WebServer\Exceptions\LocalizedException;
use WebServer\Filesystem\StaticFileManager;
use WebServer\Filesystem\AdminFileManager;

/**
 * @package greezlu/ws-router
 */
class Page implements ResultInterface
{
    protected const TEMPLATE_FOLDER     = 'view/template';

    protected const CONTENT_FOLDER      = 'view/content';

    protected const CSS_FOLDER          = 'css';

    protected const SCRIPT_FOLDER       = 'js';

    protected const IMAGE_FOLDER        = 'images';

    /**
     * @var string
     */
    private string $template;

    /**
     * @var string
     */
    private string $content;

    /**
     * @var array
     */
    private array $params;

    /**
     * @var StaticFileManager
     */
    private StaticFileManager $staticFileManager;

    /**
     * @var AdminFileManager
     */
    private AdminFileManager $adminFileManager;

    /**
     * @param string $template
     * @param string $content
     * @param array|null $data
     * @param string|null $title
     * @throws LocalizedException
     */
    public function __construct(
        string $template,
        string $content,
        array $data = [],
        string $title = null
    ) {
        $this->staticFileManager = new StaticFileManager();
        $this->adminFileManager = new AdminFileManager();

        $templateFilePath = $this->adminFileManager->getFullPath(
            static::TEMPLATE_FOLDER . '/' . $template . '.php'
        );
        if ($this->adminFileManager->isFile($templateFilePath)) {
            $this->template = $templateFilePath;
        } else {
            throw new LocalizedException('Undefined template file: ' . $templateFilePath);
        }

        $contentFilePath = $this->adminFileManager->getFullPath(
            static::CONTENT_FOLDER . '/' . $content . '.php'
        );
        if ($this->adminFileManager->isFile($contentFilePath)) {
            $this->content = $contentFilePath;
        } else {
            throw new LocalizedException('Undefined content file: ' . $contentFilePath);
        }

        $title = !is_null($title)
            ? Config::SERVER_NAME . " | $title"
            : Config::SERVER_NAME;

        $this->params = [
            'page'          => $this,
            'pageData'      => $data,
            'title'         => $title,
            'cssList'       => [],
            'scriptList'    => [],
            'imageList'     => []
        ];

        $this->addCssFile('template/' . $template)
            ->addCssFile('content/' . $content)
            ->addCssFile('font/Roboto');
    }

    /**
     * Add new css file to list.
     *
     * @param string $cssFile
     * @return $this
     */
    public function addCssFile(string $cssFile): Page
    {
        $filePath = static::CSS_FOLDER . '/' . $cssFile . '.css';

        if ($this->staticFileManager->isFile($filePath)) {
            $this->params['cssList'][] = $this->staticFileManager->getPublicPath($filePath);
        }

        return $this;
    }

    /**
     * Add new script file to list.
     *
     * @param string $scriptFile
     * @return $this
     */
    public function addScriptFile(string $scriptFile): Page
    {
        $filePath = static::SCRIPT_FOLDER . '/' . $scriptFile . '.js';

        if ($this->staticFileManager->isFile($filePath)) {
            $this->params['scriptList'][] = $this->staticFileManager->getPublicPath($filePath);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function addPageData(string $name, $value): Page
    {
        $this->params['pageData'][$name] = $value;
        return $this;
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $this->viewTemplate();
    }

    /**
     * Render template file.
     *
     * @return void
     * @throws LocalizedException
     */
    protected function viewTemplate(): void
    {
        if (!$this->adminFileManager->isFile($this->template)) {
            throw new LocalizedException('Unable to include file: ' . $this->template);
        }

        extract($this->params);

        include $this->adminFileManager->getFullPath($this->template);
    }

    /**
     * Render content file.
     *
     * @return void
     * @throws LocalizedException
     */
    private function viewContent(): void
    {
        if (!$this->adminFileManager->isFile($this->content)) {
            throw new LocalizedException('Unable to include file: ' . $this->content);
        }

        extract($this->params);

        include $this->adminFileManager->getFullPath($this->content);
    }
}
