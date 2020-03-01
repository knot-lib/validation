<?php
declare(strict_types=1);

namespace KnotLib\Validation\Util;

use KnotLib\Validation\ValidationError;

trait SingleStringFieldValueTrait
{
    /** @var string */
    private $field_code;

    /** @var string */
    private $field_value;

    /**
     * @return string
     */
    public function getFieldCode(): string
    {
        return $this->field_code;
    }

    /**
     * @param string $field_code
     */
    public function setFieldCode(string $field_code)
    {
        $this->field_code = $field_code;
    }

    /**
     * @return string
     */
    public function getFieldValue(): string
    {
        return $this->field_value;
    }

    /**
     * @param string $field_value
     */
    public function setFieldValue(string $field_value)
    {
        $this->field_value = $field_value;
    }

    /**
     * Returns field display name
     *
     * @param string $field_code
     *
     * @return string
     */
    public abstract function getFieldDisplayName(string $field_code) : string;

    /**
     * Make validation error
     *
     * @param int $error_code
     * @param string $message
     *
     * @return ValidationError
     */
    public function makeError(int $error_code, string $message) : ValidationError
    {
        return new ValidationError(
            $error_code, $message, $this->getFieldDisplayName($this->field_code), $this->field_code, $this->field_value
        );
    }

}