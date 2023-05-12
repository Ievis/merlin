<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class TaskController
{
    public function show(Request $request, $task)
    {
        echo $task;
        return $task;
    }

    public function create(Request $request, $id)
    {
        dump('create');
    }
}