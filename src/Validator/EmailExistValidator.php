<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailExistValidator extends ConstraintValidator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof EmailExist) {
            throw new UnexpectedTypeException($constraint, EmailExist::class);
        }

        if (null == $value || $value = '' || $this->userRepository->count(["email" => $value]) > 0) {
            return;
        }

        $this->context->buildViolation($constraint->message)
        ->addViolation();
    }
}
