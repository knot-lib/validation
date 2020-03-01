<?php
declare(strict_types=1);

namespace KnotLib\Validation\Test;

use KnotLib\Validation\ValidationError;
use PHPUnit\Framework\TestCase;

final class SingleStringFieldValueTraitTest extends TestCase
{
    public function testFieldCode()
    {
        $field_value = new SingleStringFieldValue('age', '23');

        $this->assertEquals('age', $field_value->getFieldCode());

        $field_value->setFieldCode('weight');
        $field_value->setFieldValue('89');

        $this->assertEquals('weight', $field_value->getFieldCode());
    }

    public function testFieldValue()
    {
        $field_value = new SingleStringFieldValue('age', '23');

        $this->assertEquals('23', $field_value->getFieldValue());

        $field_value->setFieldCode('weight');
        $field_value->setFieldValue('89');

        $this->assertEquals('89', $field_value->getFieldValue());
    }

    public function testGetFieldDisplayName()
    {
        $field_value = new SingleStringFieldValue('age', '23');

        $this->assertEquals('years of age', $field_value->getFieldDisplayName('age'));
    }

    public function testMakeError()
    {
        $field_value = new SingleStringFieldValue('age', '23');

        $this->assertEquals(new ValidationError(
            -1, 'something is wrong!', 'years of age', 'age', '23'
        ), $field_value->makeError(-1, 'something is wrong!'));
    }
}