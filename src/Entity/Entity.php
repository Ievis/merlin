<?php

namespace App\Entity;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class Entity
{
    protected function validated(Task $task, ValidatorInterface $validator)
    {
        $errors = $validator->validate($task);

        if (0 !== $errors->count()) {
            foreach ($errors as $error) {
                $errorBag[$error->getPropertyPath()] = $error->getMessage();
            }

            echo json_encode($errorBag);
            die();
        }
    }
}