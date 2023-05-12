<?php

require '../vendor/autoload.php';

use App\Controller\TaskController;
use App\Providers\RouteServiceProvider;
use App\Providers\UrlMatchServiceProvider;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


var_dump(new \App\Console\Commands\HelloworldCommand());

try {
    $application = new Application();
    $application->register('generate-admin')
        ->addArgument('username', InputArgument::REQUIRED)
        ->setCode(function (InputInterface $input, OutputInterface $output): int {
            // ...

            return Command::SUCCESS;
        });
    $request = Request::createFromGlobals();
    $routes = RouteServiceProvider::process();
    $container_info = UrlMatchServiceProvider::process($request, $routes);

    $containerBuilder = new ContainerBuilder();
    $containerBuilder->register($container_info['controller'], $container_info['controller']);

    $vars = $container_info['vars'];
    $method_call_definitions = require_once '../config/CallDefinitions.php';
    $definition = new Definition($container_info['controller']);
    $definition->addMethodCall($container_info['action'], $method_call_definitions[$container_info['controller']][$container_info['action']]);
    $containerBuilder->addDefinitions([
        TaskController::class => $definition
    ]);

    return $containerBuilder->get((new $container_info['controller'])::class);

} catch (ResourceNotFoundException $e) {
    echo '404';
} catch (MethodNotAllowedException $e) {
    echo '404';

}