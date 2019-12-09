<?php
declare(strict_types=1);

namespace KnotLib\Validation\Test;

use PHPUnit\Framework\TestCase;

use KnotLib\Validation\SingleStringValueValidator;

final class SingleStringValueValidatorTest extends TestCase
{
    public function testValidateEmpty()
    {
        $tests = [
            [ 'data' => 'foo', 'expected' => false, ],
            [ 'data' => 'Falao', 'expected' => false, ],
            [ 'data' => '1', 'expected' => false, ],
            [ 'data' => 'hello world', 'expected' => false, ],
            [ 'data' => '', 'expected' => true, ],
        ];
        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateEmpty(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateEmpty(), "data: {$data}");
            }
        }
    }
    public function testValidateNotEmpty()
    {
        $tests = [
            [ 'data' => 'foo', 'expected' => true, ],
            [ 'data' => 'Falao', 'expected' => true, ],
            [ 'data' => '1', 'expected' => true, ],
            [ 'data' => 'hello world', 'expected' => true, ],
            [ 'data' => '', 'expected' => false, ],
        ];
        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateNotEmpty(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateNotEmpty(), "data: {$data}");
            }
        }
    }
    public function testValidateAplhabet()
    {
        $tests = [
            [ 'data' => 'foo', 'expected' => true, ],
            [ 'data' => 'Falao', 'expected' => true, ],
            [ 'data' => '1', 'expected' => false, ],
            [ 'data' => 'hello world', 'expected' => false, ],
        ];
        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateAlphabet(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateAlphabet(), "data: {$data}");
            }
        }
    }
    public function testValidateLowerCaseAlpha()
    {
        $tests = [
            [ 'data' => 'foo', 'expected' => true, ],
            [ 'data' => 'Falao', 'expected' => false, ],
            [ 'data' => '1', 'expected' => false, ],
            [ 'data' => 'hello world', 'expected' => false, ],
        ];
        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateLowerCaseAlpha(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateLowerCaseAlpha(), "data: {$data}");
            }
        }
    }
    public function testValidateUpperCaseAlpha()
    {
        $tests = [
            [ 'data' => 'FOO', 'expected' => true, ],
            [ 'data' => 'Falao', 'expected' => false, ],
            [ 'data' => '1', 'expected' => false, ],
            [ 'data' => 'HELLO WORLD', 'expected' => false, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateUpperCaseAlpha(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateUpperCaseAlpha(), "data: {$data}");
            }
        }
    }
    public function testValidateNumber()
    {
        $tests = [
            [ 'data' => '123', 'expected' => true, ],
            [ 'data' => 'Falao', 'expected' => false, ],
            [ 'data' => '3.14', 'expected' => false, ],
            [ 'data' => 'HELLO WORLD', 'expected' => false, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateNumber(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateNumber(), "data: {$data}");
            }
        }
    }
    public function testValidateAlphaNum()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => true, ],
            [ 'data' => 'stk2k', 'expected' => true, ],
            [ 'data' => 'Falao', 'expected' => true, ],
            [ 'data' => '3.14', 'expected' => false, ],
            [ 'data' => 'Hello World', 'expected' => false, ],
            [ 'data' => '123', 'expected' => true, ],
            [ 'data' => 'info@example.com', 'expected' => false, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateAlphaNum(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateAlphaNum(), "data: {$data}");
            }
        }
    }
    public function testValidateEmail()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => false, ],
            [ 'data' => 'stk2k', 'expected' => false, ],
            [ 'data' => 'Falao', 'expected' => false, ],
            [ 'data' => '3.14', 'expected' => false, ],
            [ 'data' => 'Hello World', 'expected' => false, ],
            [ 'data' => '123', 'expected' => false, ],
            [ 'data' => 'info@example.com', 'expected' => true, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateEmail(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateEmail(), "data: {$data}");
            }
        }
    }
    public function testValidateURL()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => false, ],
            [ 'data' => 'stk2k', 'expected' => false, ],
            [ 'data' => 'Falao', 'expected' => false, ],
            [ 'data' => '3.14', 'expected' => false, ],
            [ 'data' => 'Hello World', 'expected' => false, ],
            [ 'data' => '123', 'expected' => false, ],
            [ 'data' => 'info@example.com', 'expected' => false, ],
            [ 'data' => 'http://example.com', 'expected' => true, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateURL(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateURL(), "data: {$data}");
            }
        }
    }
    public function testValidateMaxStringLength()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => true, 'max_length' => 4, 'mb' => false ],
            [ 'data' => 'stk2k', 'expected' => false, 'max_length' => 4, 'mb' => false ],
            [ 'data' => 'Falao', 'expected' => false, 'max_length' => 4, 'mb' => false ],
            [ 'data' => '3.14', 'expected' => true, 'max_length' => 4, 'mb' => true ],
            [ 'data' => 'おはよう', 'expected' => true, 'max_length' => 4, 'mb' => true ],
            [ 'data' => 'おはよう！', 'expected' => false, 'max_length' => 4, 'mb' => true ],
            [ 'data' => '123', 'expected' => true, 'max_length' => 4, 'mb' => false ],
            [ 'data' => 'info@example.com', 'expected' => false, 'max_length' => 4, 'mb' => false ],
            [ 'data' => 'http://example.com', 'expected' => false, 'max_length' => 4, 'mb' => false ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            $max_length = $test['max_length'];
            $mb = $test['mb'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateMaxStringLength($max_length, $mb), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateMaxStringLength($max_length, $mb), "data: {$data}");
            }
        }
    }
    public function testValidateMinStringLength()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => true, 'min_length' => 4, 'mb' => false ],
            [ 'data' => 'stk2k', 'expected' => true, 'min_length' => 4, 'mb' => false ],
            [ 'data' => 'Falao', 'expected' => true, 'min_length' => 4, 'mb' => false ],
            [ 'data' => '3.14', 'expected' => true, 'min_length' => 4, 'mb' => true ],
            [ 'data' => 'おはよう', 'expected' => true, 'min_length' => 4, 'mb' => true ],
            [ 'data' => 'おはよう！', 'expected' => true, 'min_length' => 4, 'mb' => true ],
            [ 'data' => '123', 'expected' => false, 'min_length' => 4, 'mb' => false ],
            [ 'data' => 'info@example.com', 'expected' => true, 'min_length' => 4, 'mb' => false ],
            [ 'data' => 'http://example.com', 'expected' => true, 'min_length' => 4, 'mb' => false ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            $min_length = $test['min_length'];
            $mb = $test['mb'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateMinStringLength($min_length, $mb), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateMinStringLength($min_length, $mb), "data: {$data}");
            }
        }
    }
    public function testValidateRegEx()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => true, 'regex' => '/^[0-9a-zA-Z]+$/' ],
            [ 'data' => 'stk2k', 'expected' => false, 'regex' => '/^[0-9]+$/' ],
            [ 'data' => 'Falao', 'expected' => true, 'regex' => '/^[a-zA-Z]+$/' ],
            [ 'data' => '3.14', 'expected' => false, 'regex' => '/^[0-9]+$/' ],
            [ 'data' => 'おはよう', 'expected' => true, 'regex' => '/^[ぁ-んァ-ヶー一-龠]+$/' ],
            [ 'data' => 'おはよう！', 'expected' => false, 'regex' => '/^[0-9a-zA-Z]+$/' ],
            [ 'data' => '123', 'expected' => true, 'regex' => '/^[0-9]+$/' ],
            [ 'data' => 'info@example.com', 'expected' => false, 'regex' => '/^[0-9a-zA-Z]+$/' ],
            [ 'data' => 'http://example.com', 'expected' => true, 'regex' => '/^[\w:\.\/]+$/' ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            $regex = $test['regex'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateRegEx($regex), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateRegEx($regex), "data: {$data}");
            }
        }
    }
    public function testValidateInteger()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => false ],
            [ 'data' => 'stk2k', 'expected' => false ],
            [ 'data' => 'Falao', 'expected' => false ],
            [ 'data' => '3.14', 'expected' => false ],
            [ 'data' => 'おはよう', 'expected' => false ],
            [ 'data' => 'おはよう！', 'expected' => false ],
            [ 'data' => '123', 'expected' => true ],
            [ 'data' => '-123', 'expected' => true ],
            [ 'data' => '+123', 'expected' => true ],
            [ 'data' => 'info@example.com', 'expected' => false ],
            [ 'data' => 'http://example.com', 'expected' => false ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateInteger(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateInteger(), "data: {$data}");
            }
        }
    }
    public function testValidateMinInteger()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => false, 'min' => 4 ],
            [ 'data' => 'stk2k', 'expected' => false, 'min' => 4 ],
            [ 'data' => 'Falao', 'expected' => false, 'min' => 4 ],
            [ 'data' => '3.14', 'expected' => false, 'min' => 4 ],
            [ 'data' => 'おはよう', 'expected' => false, 'min' => 4 ],
            [ 'data' => '3', 'expected' => false, 'min' => 4 ],
            [ 'data' => '4', 'expected' => true, 'min' => 4 ],
            [ 'data' => '123', 'expected' => true, 'min' => 4 ],
            [ 'data' => 'info@example.com', 'expected' => false, 'min' => 4 ],
            [ 'data' => 'http://example.com', 'expected' => false, 'min' => 4 ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            $min = $test['min'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateMinInteger($min), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateMinInteger($min), "data: {$data}");
            }
        }
    }
    public function testValidateMaxInteger()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => false, 'max' => 4 ],
            [ 'data' => 'stk2k', 'expected' => false, 'max' => 4 ],
            [ 'data' => 'Falao', 'expected' => false, 'max' => 4 ],
            [ 'data' => '3.14', 'expected' => false, 'max' => 4 ],
            [ 'data' => 'おはよう', 'expected' => false, 'max' => 4 ],
            [ 'data' => '3', 'expected' => true, 'max' => 4 ],
            [ 'data' => '4', 'expected' => true, 'max' => 4 ],
            [ 'data' => '5', 'expected' => false, 'max' => 4 ],
            [ 'data' => '-123', 'expected' => true, 'max' => 4 ],
            [ 'data' => 'info@example.com', 'expected' => false, 'max' => 4 ],
            [ 'data' => 'http://example.com', 'expected' => false, 'max' => 4 ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            $max = $test['max'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateMaxInteger($max), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateMaxInteger($max), "data: {$data}");
            }
        }
    }
    public function testValidateInArray()
    {
        $tests = [
            [ 'data' => '11PM', 'expected' => false, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => 'stk2k', 'expected' => false, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => 'Falao', 'expected' => false, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => '3.14', 'expected' => false, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => 'おはよう', 'expected' => false, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => '3', 'expected' => true, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => '4', 'expected' => true, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => '5', 'expected' => true, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => '-123', 'expected' => false, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => 'info@example.com', 'expected' => false, 'values' => [1, 2, 3, 4, 5] ],
            [ 'data' => 'http://example.com', 'expected' => false, 'values' => [1, 2, 3, 4, 5] ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            $values = $test['values'];
            if ($expected){
                $this->assertTrue((new SingleStringValueValidator($data))->validateInArray($values), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleStringValueValidator($data))->validateInArray($values), "data: {$data}");
            }
        }
    }
}