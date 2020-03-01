<?php
declare(strict_types=1);

namespace KnotLib\Validation\Util;

use KnotLib\Validation\ErrorMessageProviderInterface;
use KnotLib\Validation\ValidationError;

abstract class AbstractSingleStringFieldValueValidator
{
    const ALPHABET = '/^[a-zA-Z]+$/';
    const LOWERCASE_ALPHA = '/^[a-z]+$/';
    const UPPERCASE_ALPHA = '/^[A-Z]+$/';
    const NUMBER = '/^[0-9]+$/';
    const ALPHANUM = '/^[0-9a-zA-Z]+$/';
    const INTVAL = '/^[+-]?[0-9]+$/';
    const REGEX_EMAIL = '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/';
    const REGEX_URL = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';

    /** @var string */
    private $field_code;

    /** @var string */
    private $field_value;

    /** @var ErrorMessageProviderInterface */
    private $provider;

    /**
     * AbstractSingleStringFieldValueValidator constructor.
     *
     * @param string $field_code
     * @param string $field_value
     * @param ErrorMessageProviderInterface $provider
     */
    public function __construct(string $field_code, string $field_value, ErrorMessageProviderInterface $provider)
    {
        $this->field_code = $field_code;
        $this->field_value = $field_value;
        $this->provider = $provider;
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
     * @return string
     */
    public function getFieldCode() : string
    {
        return $this->field_code;
    }

    /**
     * Make validation error
     *
     * @param int $error_code
     *
     * @return ValidationError
     */
    public function makeError(int $error_code) : ValidationError
    {
        return new ValidationError(
            $error_code,
            $this->provider->getErrorMessage($error_code),
            $this->getFieldDisplayName($this->field_code),
            $this->field_code,
            $this->field_value
        );
    }

    /**
     * Validate empty
     *
     * @return bool
     */
    public function validateEmpty() : bool
    {
        return empty($this->field_value);
    }

    /**
     * Validate NOT empty
     *
     * @return bool
     */
    public function validateNotEmpty() : bool
    {
        return !empty($this->field_value);
    }

    /**
     * Validate alphabet
     *
     * @return bool
     */
    public function validateAlphabet() : bool
    {
        return preg_match(self::ALPHABET, $this->field_value) === 1;
    }

    /**
     * Validate lower case letter
     *
     * @return bool
     */
    public function validateLowerCaseAlpha() : bool
    {
        return preg_match(self::LOWERCASE_ALPHA, $this->field_value) === 1;
    }

    /**
     * Validate lower case letter
     *
     * @return bool
     */
    public function validateUpperCaseAlpha() : bool
    {
        return preg_match(self::UPPERCASE_ALPHA, $this->field_value) === 1;
    }

    /**
     * Validate number
     *
     * @return bool
     */
    public function validateNumber() : bool
    {
        return preg_match(self::NUMBER, $this->field_value) === 1;
    }

    /**
     * Validate alphabet or number
     *
     * @return bool
     */
    public function validateAlphaNum() : bool
    {
        return preg_match(self::ALPHANUM, $this->field_value) === 1;
    }

    /**
     * Validate email
     *
     * @return bool
     */
    public function validateEmail() : bool
    {
        return preg_match(self::REGEX_EMAIL, $this->field_value) === 1;
    }

    /**
     * Validate URL
     *
     * @return bool
     */
    public function validateURL() : bool
    {
        return preg_match(self::REGEX_URL, $this->field_value) === 1;
    }

    /**
     * Validate max string length
     *
     * @param int $max_length
     * @param bool $multibyte
     *
     * @return bool
     */
    public function validateMaxStringLength(int $max_length, bool $multibyte = true) : bool
    {
        return $multibyte ? (mb_strlen($this->field_value) <= $max_length) : (strlen($this->field_value) <= $max_length);
    }

    /**
     * Validate min string length
     *
     * @param int $min_length
     * @param bool $multibyte
     *
     * @return bool
     */
    public function validateMinStringLength(int $min_length, bool $multibyte = true) : bool
    {
        return $multibyte ? (mb_strlen($this->field_value) >= $min_length) : (strlen($this->field_value) >= $min_length);
    }

    /**
     * Validate string by regular expression
     *
     * @param string $regex
     *
     * @return bool
     */
    public function validateRegEx(string $regex) : bool
    {
        return preg_match($regex, $this->field_value) === 1;
    }

    /**
     * Validate integer
     *
     * @return bool
     */
    public function validateInteger() : bool
    {
        return preg_match(self::INTVAL, $this->field_value) === 1;
    }

    /**
     * Validate min integer
     *
     * @param int $min
     *
     * @return bool
     */
    public function validateMinInteger(int $min) : bool
    {
        return $this->validateInteger() && intval($this->field_value) >= $min;
    }

    /**
     * Validate max integer
     *
     * @param int $max
     *
     * @return bool
     */
    public function validateMaxInteger(int $max) : bool
    {
        return $this->validateInteger() && intval($this->field_value) <= $max;
    }

    /**
     * Validate array element
     *
     * @param array $values
     *
     * @return bool
     */
    public function validateInArray(array $values) : bool
    {
        return in_array($this->field_value, $values);
    }

    /**
     * Validate JSON
     *
     * @return bool
     */
    public function validateJson() : bool
    {
        json_decode($this->field_value);
        return json_last_error() === JSON_ERROR_NONE;
    }
}