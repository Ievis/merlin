<?php

namespace App\Service;

use App\Controller\AbstractController;

class ControllerMap
{
    public function __construct(array $controllerInfo)
    {
        $this->controllerName = $controllerInfo['controllerName'];
        $this->controllerMethod = $controllerInfo['controllerMethod'];
        $this->controllerVars = $controllerInfo['controllerVars'];
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
        $globalDefinitions = require_once __DIR__ . '/../../config/method-call-definitions.php';

        return $globalDefinitions[$this->controllerName][$this->controllerMethod];
    }
}