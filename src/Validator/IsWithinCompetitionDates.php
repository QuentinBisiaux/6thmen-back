<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class IsWithinCompetitionDates extends Constraint
{
    public string $message = 'The tournament dates must be within the competition dates.';

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}