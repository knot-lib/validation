<?php /** @noinspection DuplicatedCode */
declare(strict_types=1);

namespace KnotLib\Validation\Test;

use KnotLib\Validation\ErrorMessageProviderInterface;
use KnotLib\Validation\ValidationError;
use PHPUnit\Framework\TestCase;

final class AbstractSingleFieldValueValidatorTest extends TestCase
{
    /** @var ErrorMessageProviderInterface */
    private $provider;

    public function setUp()
    {
        parent::setUp();

        $this->provider = new class implements ErrorMessageProviderInterface {
            public function getErrorMessage(int $error_code): string
            {
                switch($error_code){
                    case -1:
                        return 'something is wrong!';
                }
                return '';
            }

        };
    }

    public function testGetFieldDisplayName()
    {
        $field_value = new SingleFieldValueValidator('age', '23', $this->provider);

        $this->assertEquals('years of age', $field_value->getFieldDisplayName('age'));
    }

    public function testMakeError()
    {
        $field_value = new SingleFieldValueValidator('age', '23', $this->provider);

        $this->assertEquals(new ValidationError(
            -1, 'something is wrong!', 'years of age', 'age', '23'
        ), $field_value->makeError(-1));
    }

    public function testGetFieldCode()
    {
        $field_value = new SingleFieldValueValidator('age', '23', $this->provider);

        $this->assertEquals('age', $field_value->getFieldCode());
    }

    public function testGetFieldValue()
    {
        $field_value = new SingleFieldValueValidator('age', '23', $this->provider);

        $this->assertEquals('23', $field_value->getFieldValue());
    }

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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateEmpty(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateEmpty(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateNotEmpty(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateNotEmpty(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateAlphabet(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateAlphabet(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateLowerCaseAlpha(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateLowerCaseAlpha(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateUpperCaseAlpha(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateUpperCaseAlpha(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateNumber(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateNumber(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateAlphaNum(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateAlphaNum(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateEmail(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateEmail(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateURL(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateURL(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateMaxStringLength($max_length, $mb), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateMaxStringLength($max_length, $mb), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateMinStringLength($min_length, $mb), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateMinStringLength($min_length, $mb), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateRegEx($regex), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateRegEx($regex), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateInteger(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateInteger(), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateMinInteger($min), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateMinInteger($min), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateMaxInteger($max), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateMaxInteger($max), "data: {$data}");
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
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateInArray($values), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateInArray($values), "data: {$data}");
            }
        }
    }
    public function testValidateJson()
    {
        $tests = [
            [ 'data' => '', 'expected' => false, ],
            [ 'data' => '[]', 'expected' => true, ],
            [ 'data' => ']', 'expected' => false, ],
            [ 'data' => '["foo","bar","baz"]', 'expected' => true, ],
            [ 'data' => '["foo":"bar","baz"]', 'expected' => false, ],
            [ 'data' => '{"foo":"bar","baz"}', 'expected' => false, ],
            [ 'data' => '{"foo":"bar","baz":"qux"}', 'expected' => true, ],
            [ 'data' => '{"foo":"bar","baz":[1,2,3]}', 'expected' => true, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateJson(), "data: {$data}");
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateJson(), "data: {$data}");
            }
        }
    }
    public function testValidateArray()
    {
        $tests = [
            [ 'data' => '', 'expected' => false, ],
            [ 'data' => [], 'expected' => true, ],
            [ 'data' => ']', 'expected' => false, ],
            [ 'data' => '["foo","bar","baz"]', 'expected' => false, ],
            [ 'data' => 2, 'expected' => false, ],
            [ 'data' => -0.1, 'expected' => false, ],
            [ 'data' => 'Hello, World!', 'expected' => false, ],
            [ 'data' => null, 'expected' => false, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateArray(), 'data:' . print_r($data, true));
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateArray(), 'data:' . print_r($data, true));
            }
        }
    }
    public function testValidateString()
    {
        $tests = [
            [ 'data' => '', 'expected' => true, ],
            [ 'data' => [], 'expected' => false, ],
            [ 'data' => ']', 'expected' => true, ],
            [ 'data' => '["foo","bar","baz"]', 'expected' => true, ],
            [ 'data' => 2, 'expected' => false, ],
            [ 'data' => -0.1, 'expected' => false, ],
            [ 'data' => 'Hello, World!', 'expected' => true, ],
            [ 'data' => null, 'expected' => false, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateString(), 'data:' . print_r($data, true));
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateString(), 'data:' . print_r($data, true));
            }
        }
    }
    public function testValidateSha1Hash()
    {
        $tests = [
            [ 'data' => '', 'expected' => false, ],
            [ 'data' => [], 'expected' => false, ],
            [ 'data' => ']', 'expected' => false, ],
            [ 'data' => 2, 'expected' => false, ],
            [ 'data' => -0.1, 'expected' => false, ],
            [ 'data' => 'Hello, World!', 'expected' => false, ],
            [ 'data' => null, 'expected' => false, ],
            [ 'data' => 'e52a7284d144ad46a7bab34048fcc87fbfc38f76', 'expected' => true, ],
            [ 'data' => '830774887C4889E95607FD4279A1C4E6A2E62982', 'expected' => true, ],
            [ 'data' => 'e52a7284d144ad46a7bab34048fcc87fbfc38f76b', 'expected' => false, ],
            [ 'data' => 'e52a7284d144ad46a7bab34048fcc87fbfc38f7', 'expected' => false, ],
            [ 'data' => 'e52a7284d144ad46a7bab34048fcc87fbfc38f7_', 'expected' => false, ],
            [ 'data' => 'e52a7284d144ad46a7bab34048fcc87fbfc38f7g', 'expected' => false, ],
        ];

        foreach($tests as $test){
            $data = $test['data'];
            $expected = $test['expected'];
            if ($expected){
                $this->assertTrue((new SingleFieldValueValidator('',$data, $this->provider))->validateSha1Hash(), 'data:' . print_r($data, true));
            }
            else{
                $this->assertFalse((new SingleFieldValueValidator('',$data, $this->provider))->validateSha1Hash(), 'data:' . print_r($data, true));
            }
        }
    }

}