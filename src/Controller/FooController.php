<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class FooController
{
    public function index(Request $request)
    {
        dump('index');
    }

    public function load(Request $request, $id)
    {
        dump('load');
    }
}