<?php

use App\Controller\TaskController;
use Symfony\Component\HttpFoundation\Request;

$request = $request ?? Request::createFromGlobals();

return [
    TaskController::class => [
        'create' => [
            'request' => $request
        ],
        'show' => [
            'request' => $request,
            'task' => $this->controllerVars['task'] ?? null
        ]
    ]
];