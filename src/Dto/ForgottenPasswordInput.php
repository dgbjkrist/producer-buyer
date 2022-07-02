<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AcmeAssert;

class ForgottenPasswordInput
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @AcmeAssert\EmailExist
     */
    private string $email = "";

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
