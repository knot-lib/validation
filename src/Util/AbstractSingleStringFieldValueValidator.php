<?php
declare(strict_types=1);

namespace KnotLib\Validation\Util;

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

    /**
     * Returns value
     *
     * @return string
     */
    abstract public function getFieldValue() : string;

    /**
     * Validate empty
     *
     * @return bool
     */
    public function validateEmpty() : bool
    {
        return empty($this->getFieldValue());
    }

    /**
     * Validate NOT empty
     *
     * @return bool
     */
    public function validateNotEmpty() : bool
    {
        return !empty($this->getFieldValue());
    }

    /**
     * Validate alphabet
     *
     * @return bool
     */
    public function validateAlphabet() : bool
    {
        return preg_match(self::ALPHABET, $this->getFieldValue()) === 1;
    }

    /**
     * Validate lower case letter
     *
     * @return bool
     */
    public function validateLowerCaseAlpha() : bool
    {
        return preg_match(self::LOWERCASE_ALPHA, $this->getFieldValue()) === 1;
    }

    /**
     * Validate lower case letter
     *
     * @return bool
     */
    public function validateUpperCaseAlpha() : bool
    {
        return preg_match(self::UPPERCASE_ALPHA, $this->getFieldValue()) === 1;
    }

    /**
     * Validate number
     *
     * @return bool
     */
    public function validateNumber() : bool
    {
        return preg_match(self::NUMBER, $this->getFieldValue()) === 1;
    }

    /**
     * Validate alphabet or number
     *
     * @return bool
     */
    public function validateAlphaNum() : bool
    {
        return preg_match(self::ALPHANUM, $this->getFieldValue()) === 1;
    }

    /**
     * Validate email
     *
     * @return bool
     */
    public function validateEmail() : bool
    {
        return preg_match(self::REGEX_EMAIL, $this->getFieldValue()) === 1;
    }

    /**
     * Validate URL
     *
     * @return bool
     */
    public function validateURL() : bool
    {
        return preg_match(self::REGEX_URL, $this->getFieldValue()) === 1;
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
        return $multibyte ? (mb_strlen($this->getFieldValue()) <= $max_length) : (strlen($this->getFieldValue()) <= $max_length);
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
        return $multibyte ? (mb_strlen($this->getFieldValue()) >= $min_length) : (strlen($this->getFieldValue()) >= $min_length);
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
        return preg_match($regex, $this->getFieldValue()) === 1;
    }

    /**
     * Validate integer
     *
     * @return bool
     */
    public function validateInteger() : bool
    {
        return preg_match(self::INTVAL, $this->getFieldValue()) === 1;
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
        return $this->validateInteger() && intval($this->getFieldValue()) >= $min;
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
        return $this->validateInteger() && intval($this->getFieldValue()) <= $max;
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
        return in_array($this->getFieldValue(), $values);
    }

    /**
     * Validate JSON
     *
     * @return bool
     */
    public function validateJson() : bool
    {
        json_decode($this->getFieldValue());
        return json_last_error() === JSON_ERROR_NONE;
    }
}