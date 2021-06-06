<?php
declare(strict_types=1);

namespace knotlib\validation;

use JsonSerializable;

final class ValidationError implements JsonSerializable
{
    /** @var int */
    private $error_code;

    /** @var string */
    private $message;

    /** @var string */
    private $disp_field;

    /** @var string */
    private $field_code;

    /** @var mixed */
    private $field_value;

    /**
     * ValidationError constructor.
     *
     * @param int $error_code
     * @param string $message
     * @param string $disp_field
     * @param string $field_code
     * @param mixed $field_value
     */
    public function __construct(int $error_code, string $message, string $disp_field, string $field_code, $field_value)
    {
        $this->error_code = $error_code;
        $this->message = $message;
        $this->disp_field = $disp_field;
        $this->field_code = $field_code;
        $this->field_value = $field_value;
    }

    /**
     * Get error code
     *
     * @return int
     */
    public function getErrorCode() : int
    {
        return $this->error_code;
    }

    /**
     * Get error message
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Get display field name
     *
     * @return string
     */
    public function getDispField() : string
    {
        return $this->disp_field;
    }

    /**
     * Get field code
     *
     * @return string
     */
    public function getFieldCode() : string
    {
        return $this->field_code;
    }

    /**
     * Get field code
     *
     * @return mixed
     */
    public function getFieldValue()
    {
        return $this->field_value;
    }

    /**
     * Json serialize
     *
     * @return mixed|void
     */
    public function jsonSerialize()
    {
        return [
            'error_code' => $this->error_code,
            'message' => $this->message,
            'disp_field' => $this->disp_field,
            'field_code' => $this->field_code,
            'field_value' => $this->field_value,
        ];
    }


}