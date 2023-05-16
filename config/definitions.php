<?php

use App\Controller\TaskController;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

$request = $request ?? Request::createFromGlobals();
$em = require __DIR__ . '/../config/bootstrap.php';

return [
    TaskController::class => [
        'create' => [
            'request' => $request
        ],
        'show' => [
            'request' => $request,
            'task' => $em->find(Task::class,
                    empty($this->controllerVars['task'])
                        ? $request->get('task_id') ?? 0
                        : $this->controllerVars['task']) ?? null
        ]
    ]
];