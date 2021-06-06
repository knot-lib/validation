<?php
declare(strict_types=1);

namespace knotlib\validation\test\classes;

use knotlib\validation\util\AbstractSingleFieldValueValidator;

final class SingleFieldValueValidator extends AbstractSingleFieldValueValidator
{
    public function getFieldDisplayName(string $field_code): string
    {
        $map = [
            'age' => 'years of age',
        ];
        return $map[$field_code] ?? "";
    }

}