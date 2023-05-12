<?php

function dump(...$args)
{
    foreach ($args as $arg) {
        var_dump($arg);
    }
}