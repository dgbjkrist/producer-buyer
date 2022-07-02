<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Embeddable
 */
class ForgottenPassword
{
    /**
     * @ORM\column(type="uuid", unique=true, nullable=true)
     */
    private ?Uuid $token = null;

    /**
     * @ORM\column(type="datetime_immutable", options={"default":"CURRENT_TIMESTAMP"}, nullable=true)
     */
    private ?DateTimeImmutable $requestedAt;

    public function __construct()
    {
        $this->token = Uuid::v4();
        $this->requestedAt = new DateTimeImmutable();
    }


    public function getToken(): ?Uuid
    {
        return $this->token;
    }

    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getRequestedAt(): ?DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function setRequestedAt($requestedAt): self
    {
        $this->requestedAt = $requestedAt;
        return $this;
    }
}
