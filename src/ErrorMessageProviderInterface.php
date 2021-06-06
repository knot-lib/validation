<?php
declare(strict_types=1);

namespace knotlib\validation;

interface ErrorMessageProviderInterface
{
    /**
     * Provide error message associated with the specified error code
     *
     * @param int $error_code
     *
     * @return string
     */
    public function getErrorMessage(int $error_code) : string;
}