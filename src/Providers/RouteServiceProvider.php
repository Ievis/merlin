<?php

namespace App\Providers;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

class RouteServiceProvider
{
    public static function process()
    {
        $fileLocator = new FileLocator(__DIR__ . '/../../config');
        $loader = new YamlFileLoader($fileLocator);
        return $loader->load('routes.yaml');
    }
}