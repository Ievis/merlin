<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractController
{

    protected EntityManager $em;
    protected ValidatorInterface $validator;

    public function __construct()
    {
        $this->em = require __DIR__ . '/../../config/bootstrap.php';

        $this->validator = Validation::createValidatorBuilder()
            ->addYamlMapping(__DIR__ . '/../../config/Validatior/validation.yaml')
            ->getValidator();
    }


}