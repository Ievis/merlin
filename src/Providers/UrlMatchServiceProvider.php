<?php

namespace App\Providers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class UrlMatchServiceProvider
{
    public static function process(Request $request, $routes)
    {
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

        return [
            'controller' => $controller,
            'action' => $action,
            'vars' => $vars
        ];
    }
}