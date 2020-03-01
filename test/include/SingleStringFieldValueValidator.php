<?php
declare(strict_types=1);

namespace KnotLib\Validation\Test;

use KnotLib\Validation\Util\AbstractSingleStringFieldValueValidator;

final class SingleStringFieldValueValidator extends AbstractSingleStringFieldValueValidator
{
    /** @var string */
    private $data;

    /**
     * SingleStringValueValidator constructor.
     *
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->data;
    }
}