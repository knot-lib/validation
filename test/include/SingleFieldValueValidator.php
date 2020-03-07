<?php
declare(strict_types=1);

namespace KnotLib\Validation\Test;

use KnotLib\Validation\Util\AbstractSingleFieldValueValidator;

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