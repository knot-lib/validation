<?php
declare(strict_types=1);

namespace KnotLib\Validation\Util;

use KnotLib\Validation\ErrorMessageProviderInterface;
use KnotLib\Validation\ValidationError;

abstract class AbstractSingleFieldValueValidator
{
    const REGEX_ALPHABET = '/^[a-zA-Z]+$/';
    const REGEX_LOWERCASE_ALPHA = '/^[a-z]+$/';
    const REGEX_UPPERCASE_ALPHA = '/^[A-Z]+$/';
    const REGEX_NUMBER = '/^[0-9]+$/';
    const REGEX_ALPHANUM = '/^[0-9a-zA-Z]+$/';
    const REGEX_INTVAL = '/^[+-]?[0-9]+$/';
    const REGEX_EMAIL = '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/';
    const REGEX_URL = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';
    const REGEX_SHA1_HASH = '/^[0-9a-fA-F]{40}$/';

    /** @var string */
    private $field_code;

    /** @var mixed */
    private $field_value;

    /** @var ErrorMessageProviderInterface */
    private $provider;

    /**
     * AbstractSingleStringFieldValueValidator constructor.
     *
     * @param string $field_code
     * @param mixed $field_value
     * @param ErrorMessageProviderInterface $provider
     */
    public function __construct(string $field_code, $field_value, ErrorMessageProviderInterface $provider)
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
     * @return string
     */
    public function getFieldValue() : string
    {
        return $this->field_value;
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
        return  $this->validateString() && preg_match(self::REGEX_ALPHABET, $this->field_value) === 1;
    }

    /**
     * Validate lower case letter
     *
     * @return bool
     */
    public function validateLowerCaseAlpha() : bool
    {
        return  $this->validateString() && preg_match(self::REGEX_LOWERCASE_ALPHA, $this->field_value) === 1;
    }

    /**
     * Validate lower case letter
     *
     * @return bool
     */
    public function validateUpperCaseAlpha() : bool
    {
        return  $this->validateString() && preg_match(self::REGEX_UPPERCASE_ALPHA, $this->field_value) === 1;
    }

    /**
     * Validate number
     *
     * @return bool
     */
    public function validateNumber() : bool
    {
        return $this->validateInteger() || $this->validateString() && preg_match(self::REGEX_NUMBER, $this->field_value) === 1;
    }

    /**
     * Validate alphabet or number
     *
     * @return bool
     */
    public function validateAlphaNum() : bool
    {
        return $this->validateString() && preg_match(self::REGEX_ALPHANUM, $this->field_value) === 1;
    }

    /**
     * Validate email
     *
     * @return bool
     */
    public function validateEmail() : bool
    {
        return $this->validateString() && preg_match(self::REGEX_EMAIL, $this->field_value) === 1;
    }

    /**
     * Validate URL
     *
     * @return bool
     */
    public function validateURL() : bool
    {
        return $this->validateString() && preg_match(self::REGEX_URL, $this->field_value) === 1;
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
        if (!$this->validateString()){
            return false;
        }
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
        if (!$this->validateString()){
            return false;
        }
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
        return $this->validateString() && preg_match($regex, $this->field_value) === 1;
    }

    /**
     * Validate integer
     *
     * @return bool
     */
    public function validateInteger() : bool
    {
        return is_int($this->field_value) || $this->validateString() && preg_match(self::REGEX_INTVAL, $this->field_value) === 1;
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
        if (!$this->validateString()){
            return false;
        }
        json_decode($this->field_value);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Validate array
     *
     * @return bool
     */
    public function validateArray() : bool
    {
        return is_array($this->field_value);
    }

    /**
     * Validate string
     *
     * @return bool
     */
    public function validateString() : bool
    {
        return is_string($this->field_value);
    }

    /**
     * Validate sha1 hash
     *
     * @return bool
     */
    public function validateSha1Hash() : bool
    {
        return  $this->validateString() && preg_match(self::REGEX_SHA1_HASH, $this->field_value) === 1;
    }

    /**
     * Validate date string
     *
     * @return bool
     */
    public function validateDateString() : bool
    {
        return  $this->validateString() && strtotime($this->field_value) !== false;
    }
}