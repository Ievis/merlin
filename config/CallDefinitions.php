<?php

use App\Controller\TaskController;

return [
    TaskController::class => [
        'create' => [
            'request' => $request
        ],
        'show' => [
            'request' => $request,
            'task' => $vars['task'] ?? null
        ]
    ]
];