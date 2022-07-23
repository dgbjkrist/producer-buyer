<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\EntityListener\ProducerListener;

/**
 * @ORM\Entity
 * @ORM\EntityListeners({ProducerListener::class})
 */
class Producer extends User
{
    public const ROLE = "producer";

    /**
     * @ORM\OneToOne(targetEntity="Farm", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Farm $farm = null;

    public function getRoles()
    {
        return ["ROLE_PRODUCER"];
    }

    public function getFarm(): ?Farm
    {
        return $this->farm;
    }

    public function setFarm($farm): void
    {
        $this->farm = $farm;
    }
}
