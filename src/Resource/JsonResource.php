<?php

namespace App\Resource;

use App\Entity\Entity;

class JsonResource
{

    protected Entity $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }
}