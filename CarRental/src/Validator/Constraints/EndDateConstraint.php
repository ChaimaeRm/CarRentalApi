<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute] class EndDateConstraint extends Constraint
{
    public $message = 'The end date must be greater than the start date.';

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}
