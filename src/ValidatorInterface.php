<?php
declare(strict_types=1);

namespace knotlib\validation;

interface ValidatorInterface
{
    /**
     * Execute validation
     *
     * @return ValidationError[]
     */
    public function validate() : array ;
}