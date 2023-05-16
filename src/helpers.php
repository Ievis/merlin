<?php

function dump(...$args)
{
    foreach ($args as $arg) {
        var_dump($arg);
    }
}

function abort($statusCode)
{
    echo json_encode([
        'status' => 'not_found',
        'result' => null
    ]);

    die($statusCode);
}