<?php
declare(strict_types=1);

namespace KnotLib\Validation\Test;

use KnotLib\Validation\Util\AbstractSingleStringFieldValueValidator;

final class SingleStringFieldValueValidator extends AbstractSingleStringFieldValueValidator
{
    public function getFieldDisplayName(string $field_code): string
    {
        $map = [
            'age' => 'years of age',
        ];
        return $map[$field_code] ?? "";
    }

}