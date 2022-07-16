<?php

namespace Jhnbrn90\CasValidator\Test;

use Jhnbrn90\CasValidator\CasNumberValidator;
use Jhnbrn90\CasValidator\DTO\InvalidCasNumber;
use Jhnbrn90\CasValidator\DTO\ValidCasNumber;
use PHPUnit\Framework\TestCase;

class CasValidatorTest extends TestCase
{
    /** 
     * @test
     * @dataProvider validCasNumbersProvider
     */
    public function it_correctly_validates_valid_cas_numbers(string $casNumber, int $checkDigit)
    {
        $validator = new CasNumberValidator();
        $validatedCasNumber = $validator->validate($casNumber);
        
        $this->assertInstanceOf(ValidCasNumber::class, $validatedCasNumber);
        $this->assertEquals($casNumber, $validatedCasNumber->casNumber);
        $this->assertEquals($checkDigit, $validatedCasNumber->check_digit);
        $this->assertTrue($validatedCasNumber->isValid());
    }
    
    /** 
     * @test
     * @dataProvider InvalidCasNumbersProvider
     */
    public function it_correctly_validates_invalid_cas_numbers(string $invalidCasNumber)
    {
        $validator = new CasNumberValidator();
        $validatedCasNumber = $validator->validate($invalidCasNumber);
        
        $this->assertInstanceOf(InvalidCasNumber::class, $validatedCasNumber);
        $this->assertEquals($invalidCasNumber, $validatedCasNumber->casNumber);
        $this->assertFalse($validatedCasNumber->isValid());
    }

    public function validCasNumbersProvider(): \Generator
    {
        yield "acetone" => ['67-64-1', 1];
        yield "benzyl bromide" => ['100-39-0', 0];
        yield "iso-propanol" => ['67-63-0', 0];
        yield "methanol" => ['67-56-1', 1];
        yield "ethanol" => ['64-17-5', 5];
        yield "ethyl acetate" => ['141-78-6', 6];
        yield "aspirin" => ['50-78-2', 2];
        yield "naphthalene" => ['91-20-3', 3];
    }
    
    public function InvalidCasNumbersProvider(): \Generator
    {
        yield "invalid acetone" => ['67-62-1'];
        yield "invalid benzyl bromide" => ['100-39-2'];
        yield "invalid iso-propanol" => ['67-62-0'];
        yield "invalid methanol" => ['69-56-1'];
        yield "invalid ethanol" => ['64-171-5'];
        yield "invalid ethyl acetate" => ['141-79-6'];
        yield "invalid aspirin" => ['050-78-2'];
        yield "invalid naphthalene" => ['91-20-1'];
    }
    
    /** @test */
    public function it_does_not_allow_left_padded_zeroes()
    {
        $validator = new CasNumberValidator();
        $leftPaddedValidCasNumber = '000100-39-0';
        $validatedCasNumber = $validator->validate($leftPaddedValidCasNumber);
        $this->assertInstanceOf(InvalidCasNumber::class, $validatedCasNumber);
    }
}