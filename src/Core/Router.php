<?php
/** Copyright github.com/greezlu */

declare(strict_types = 1);

namespace WebServer\Core;

use WebServer\Controllers\ErrorController;
use WebServer\Interfaces\ControllerInterface;
use WebServer\Interfaces\ResultInterface;

/**
 * @package greezlu/ws-router
 */
class Router
{
    public function __construct()
    {
        $request            = new Request();
        $frontController    = new FrontController($request);

        $controllerName = $frontController->getControllerName();
        $actionName     = $frontController->getActionName();

        if (!method_exists($controllerName, $actionName)) {
            $controllerName = ErrorController::class;
            $actionName     = 'error404';
        }

        try {
            /** @var ControllerInterface $actionController */
            $actionController   = new $controllerName($request);
        } catch (\Exception $error) {
            $actionController   = new ErrorController($request);
            $actionName         = 'error500';
        } finally {
            /** @var ResultInterface $result */
            $result = call_user_func([$actionController, $actionName], $request);
        }

        if ($result instanceof ResultInterface) {
            $result->execute();
        }
    }
}
