<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class GreaterThanDateOrNullValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof GreaterThanDateOrNull) {
            throw new UnexpectedTypeException($constraint, GreaterThanDateOrNull::class);
        }

        if (null === $value) {
            return;
        }

        if (!$value instanceof \DateTimeInterface) {
            throw new UnexpectedValueException($value, \DateTimeInterface::class);
        }

        $comparedValue = $this->context->getObject()->{'get'.ucfirst($constraint->comparedProperty)}();

        if (!$comparedValue instanceof \DateTimeInterface) {
            throw new UnexpectedValueException($comparedValue, \DateTimeInterface::class);
        }

        if ($value <= $comparedValue) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}