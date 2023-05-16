<?php

namespace App\Resource;

use App\Entity\Entity;

class TaskResource extends JsonResource
{
    public function __construct(Entity $entity)
    {
        parent::__construct($entity);

        echo json_encode($this->toArray());
    }


    private function toArray()
    {
        return [
            'id' => $this->entity->getId(),
            'name' => $this->entity->getName(),
            'result' => $this->entity->getResult(),
            'status' => empty($this->entity->getResult()) ? 'wait' : 'ready',
            'retry_id' => $this->entity->getRetryId(),
        ];
    }
}