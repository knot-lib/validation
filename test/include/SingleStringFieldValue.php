<?php
declare(strict_types=1);

namespace KnotLib\Validation\Test;

use KnotLib\Validation\Util\SingleStringFieldValueTrait;

final class SingleStringFieldValue
{
    use SingleStringFieldValueTrait;

    /**
     * SingleStringValueTrait constructor.
     *
     * @param string $field_code
     * @param string $field_value
     */
    public function __construct(string $field_code, string $field_value)
    {
        $this->setFieldCode($field_code);
        $this->setFieldValue($field_value);
    }

    /**
     * @param string $field_code
     *
     * @return string
     */
    public function getFieldDisplayName(string $field_code): string
    {
        $map = [
            'age' => 'years of age',
        ];
        return $map[$field_code] ?? "";
    }


}