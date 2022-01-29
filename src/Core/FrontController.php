<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Core;

/**
 * @package greezlu/ws-router
 */
class FrontController
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param Request
     */
    public function __construct(
        Request $request
    ) {
        $this->request = $request;
    }

    /**
     * Get controller class from current request.
     *
     * @return string
     */
    public function getControllerName(): string
    {
        $uriComponents = $this->request->url;

        $controllerName = !empty($uriComponents[0])
            ? addslashes($uriComponents[0])
            : 'index';

        return '\\WebServer\\Controllers\\' . ucfirst($controllerName) . 'Controller';
    }

    /**
     * Get action name from current request.
     *
     * @return string
     */
    public function getActionName(): string
    {
        $uriComponents = $this->request->url;

        if (isset($uriComponents[0])
            && (strtolower($uriComponents[0]) === 'static'
                || strtolower($uriComponents[0]) === 'pub')
        ) {
            return 'index';
        }

        if (isset($uriComponents[1])) {
            return addslashes($uriComponents[1]);
        }

        $method = $this->request->method;
        $id = $this->request->getParams['id'] ?? null;

        if (is_numeric($id)) {
            switch ($method) {
                case('GET'):
                    $actionName = 'show';
                    break;
                case('PUT'):
                    $actionName = 'update';
                    break;
                case('DELETE'):
                    $actionName = 'destroy';
                    break;
                default:
                    $actionName = 'index';
            }
        } else {
            $actionName = $method === 'POST'
                ? 'store'
                : 'index';
        }

        return $actionName;
    }
}
