<?php

use App\Controller\TaskController;

return [
    TaskController::class => [
        'create' => [
            'request' => $request,
            'id' => $vars['id'] ?? null
        ],
        'show' => [
            'request' => $request
        ]
    ]
];