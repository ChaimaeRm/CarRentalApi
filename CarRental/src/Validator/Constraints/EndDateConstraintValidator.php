<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Entity\Reservation;

class EndDateConstraintValidator extends ConstraintValidator
{
    /**
     * @param Reservation $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof Reservation) {
            throw new \LogicException('This constraint can only be used with Reservation objects.');
        }

        if ($value->getEndDate() <= $value->getStartDate()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('endDate')
                ->addViolation();
        }
    }
}
