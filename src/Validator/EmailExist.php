<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EmailExist extends Constraint
{
    public string $message = "Cette adresse email n'existe pas";
}
