<?php

namespace App\Service;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ControllerMap
{

    private Request $request;

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    public function __construct(array $controllerInfo)
    {
        $this->controllerName = $controllerInfo['controllerName'];
        $this->controllerMethod = $controllerInfo['controllerMethod'];
        $this->controllerVars = $controllerInfo['controllerVars'];
        $this->request = $controllerInfo['request'];
    }

    private string $controllerName;

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getControllerMethod(): string
    {
        return $this->controllerMethod;
    }

    /**
     * @return array
     */
    public function getControllerVars(): array
    {
        return $this->controllerVars;
    }

    private string $controllerMethod;
    private array $controllerVars;

    private array $methodCallDefinitions;

    /**
     * @return array
     */
    public function getMethodCallDefinitions(): array
    {
        $request = $this->getRequest();
        $globalDefinitions = require_once __DIR__ . '/../../config/definitions.php';

        return $globalDefinitions[$this->controllerName][$this->controllerMethod];
    }
}