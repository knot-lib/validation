<?php
declare(strict_types=1);

namespace KnotLib\Validation;

interface ValidatorInterface
{
    /**
     * Execute validation
     *
     * @return ValidationError[]
     */
    public function validate() : array ;
}