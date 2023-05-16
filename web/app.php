<?php

require '../vendor/autoload.php';

use App\Controller\TaskController;
use App\Providers\RouteServiceProvider;
use App\Providers\UrlMatchServiceProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
    $request = Request::createFromGlobals();
    $routes = RouteServiceProvider::process();
    $controllerInfo = UrlMatchServiceProvider::process($request, $routes);

    $controllerName = $controllerInfo->getControllerName();
    $controllerMethod = $controllerInfo->getControllerMethod();
    $controllerVars = $controllerInfo->getControllerVars();
    $controllerDefinitions = $controllerInfo->getMethodCallDefinitions();

    $containerBuilder = new ContainerBuilder();
    $containerBuilder->register($controllerName, $controllerName);

    $definition = new Definition($controllerName);
    $definition->addMethodCall($controllerMethod, $controllerDefinitions);
    $containerBuilder->addDefinitions([
        $controllerName => $definition
    ]);

    return $containerBuilder->get((new $controllerName)::class);

} catch (ResourceNotFoundException $e) {
    abort(404);
} catch (MethodNotAllowedException $e) {
    echo json_encode([
        'status' => 'not_found',
        'message' => 'bad http-verb',
        'result' => null
    ]);
}