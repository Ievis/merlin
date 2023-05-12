<?php

require '../vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use App\Controller\FooController;


try {
    $request = Request::createFromGlobals();

    $containerBuilder = new ContainerBuilder();
    $containerBuilder->register(FooController::class, FooController::class);

    $definition = new Definition(FooController::class);

    $fileLocator = new FileLocator(__DIR__ . '/../config');
    $loader = new YamlFileLoader($fileLocator);
    $routes = $loader->load('routes.yaml');

    $context = new RequestContext();
    $context->fromRequest($request);

    $matcher = new UrlMatcher($routes, $context);
    $parameters = $matcher->match($context->getPathInfo());

    $controller_info = explode('::', $parameters['_controller']);

    $controller = $controller_info[0];
    $action = $controller_info[1];

    $vars = array_diff($parameters, [
        '_route' => $parameters['_route'],
        '_controller' => $parameters['_controller']
    ]);

    $method_call_definitions = [
        FooController::class => [
            'load' => [
                'request' => $request,
                'id' => $vars['id'] ?? null
            ],
            'index' => [
                'request' => $request
            ]
        ]
    ];

    $definition->addMethodCall($action, $method_call_definitions[$controller][$action]);


    $containerBuilder->addDefinitions([
        FooController::class => $definition
    ]);

    $containerBuilder->get((new $controller)::class);

} catch (ResourceNotFoundException $e) {
    return json_encode([
        'success' => false
    ]);
}