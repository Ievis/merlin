<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[ORM\Entity]
#[ORM\Table(name: 'tasks')]
class Task extends Entity
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    private string $name;
    #[ORM\Column(type: 'string')]
    private string|null $photo;
    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $result;
    #[ORM\Column(type: 'string', nullable: true)]
    private string|null $retry_id;
    #[ORM\Column(type: 'integer', nullable: true)]
    private int|null $retries;

    /**
     * @return int|null
     */
    public function getRetries(): ?int
    {
        return $this->retries;
    }

    /**
     * @param int|null $retries
     */
    public function setRetries(?int $retries): void
    {
        $this->retries = $retries;
    }


    public function validated(Task $task, ValidatorInterface $validator)
    {
        parent::validated($task, $validator);
    }

    /**
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string|null $photo
     */
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return string|null
     */
    public function getResult(): ?string
    {
        return $this->result ?? '';
    }

    /**
     * @param string|null $result
     */
    public function setResult(?string $result): void
    {
        $this->result = $result;
    }

    /**
     * @return string|null
     */
    public function getRetryId(): ?string
    {
        return $this->retry_id ?? '';
    }

    /**
     * @param string|null $retry_id
     */
    public function setRetryId(?string $retry_id): void
    {
        $this->retry_id = $retry_id;
    }

    public function __construct(array $attributes)
    {
        $this->name = (string)$attributes['name'];
        $this->photo = (string)$attributes['photo'];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}