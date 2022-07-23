<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Farm
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(type="uuid", unique=true)
     */
    protected Uuid $uuid;

    /**
     * @ORM\Column(nullable=true)
     * @Assert\NotBlank
     */
    protected ?string $name = null;

    /**
     * @ORM\Column(nullable=true)
     */
    protected ?string $description = null;

    /**
     * @ORM\OneToOne(targetEntity="Producer", mappedBy="farm")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private Producer $producer;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Get the value of uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getProducer(): Producer
    {
        return $this->producer;
    }

    public function setProducer($producer): void
    {
        $this->producer = $producer;
    }
}
