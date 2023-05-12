<?php

require '../vendor/autoload.php';

use App\Providers\RouteServiceProvider;
use App\Providers\UrlMatchServiceProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use App\Controller\TaskController;


try {
    $request = Request::createFromGlobals();
    $routes = RouteServiceProvider::process();
    $container_info = UrlMatchServiceProvider::process($request, $routes);

    $containerBuilder = new ContainerBuilder();
    $containerBuilder->register($container_info['controller'], $container_info['controller']);

    $method_call_definitions = require_once '../config/CallDefinitions.php';
    $definition = new Definition($container_info['controller']);
    $definition->addMethodCall($container_info['action'], $method_call_definitions[$container_info['controller']][$container_info['action']]);
    $containerBuilder->addDefinitions([
        TaskController::class => $definition
    ]);

    $containerBuilder->get((new $container_info['controller'])::class);

} catch (ResourceNotFoundException $e) {
    echo $e->getMessage();
} catch (MethodNotAllowedException $e) {
    echo $e->getMessage();
}