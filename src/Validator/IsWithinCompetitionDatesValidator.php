<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Domain\League\Entity\Tournament;

class IsWithinCompetitionDatesValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value instanceof Tournament) {
            throw new \InvalidArgumentException('This constraint must be used on a Tournament entity.');
        }

        /** @var IsWithinCompetitionDates $competitionDatesConstraint */
        $competitionDatesConstraint = $constraint;

        $tournament = $value;
        $competition = $tournament->getCompetition();

        if ($tournament->getStartAt() < $competition->getStartAt() || $tournament->getStartAt() > $competition->getEndAt()) {
            $this->context->buildViolation($competitionDatesConstraint->message)
                ->atPath('startAt')
                ->addViolation();
        }

        if ($tournament->getEndAt() < $competition->getStartAt() || $tournament->getEndAt() > $competition->getEndAt()) {
            $this->context->buildViolation($competitionDatesConstraint->message)
                ->atPath('endAt')
                ->addViolation();
        }
    }
}