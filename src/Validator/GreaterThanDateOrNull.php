<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class GreaterThanDateOrNull extends Constraint
{
    public string $message = 'The end date must be greater than the creation date or null.';

    public function __construct(
        public string $comparedProperty,
        array $groups = null,
        mixed $payload = null
    )
    {
        parent::__construct([], $groups, $payload);
    }

    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}