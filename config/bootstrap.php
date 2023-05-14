<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . "/../vendor/autoload.php";

$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__ . "/../src/Entities"],
    true
);

$connection = DriverManager::getConnection([
    'dbname' => 'merlin',
    'user' => 'root',
    'password' => 'root',
    'driver' => 'pdo_mysql',
    'host' => 'db',
    'path' => __DIR__ . '/../tmp/db',
], $config);


$entityManager = new EntityManager($connection, $config);