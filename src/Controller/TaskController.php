<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class TaskController
{
    public function show(Request $request, $task)
    {
        dump($task);
    }

    public function create(Request $request, $id)
    {
        dump('create');
    }
}