<?php

namespace Jhnbrn90\CasValidator;

use Jhnbrn90\CasValidator\DTO\InvalidCasNumber;
use Jhnbrn90\CasValidator\DTO\ValidatedCasNumberInterface;
use Jhnbrn90\CasValidator\DTO\ValidCasNumber;

class CasNumberValidator
{
    public static function validate(string $casNumber): ValidatedCasNumberInterface 
    {
        $parsedCasNumber = preg_replace("/-/", "", $casNumber);
        $parsedCasNumberArray = array_map('intval', str_split($parsedCasNumber));
        
        if ($parsedCasNumberArray[0] === 0) {
            // Do not allow zero (0) left padded CAS-numbers
            // Force '100-39-0' over '000100-39-0'
            return new InvalidCasNumber($casNumber);
        }
        
        $checkDigit = array_pop($parsedCasNumberArray);
        
        $sum = 0;
        $multiplier = 1;
        
        while(count($parsedCasNumberArray) > 0) {
            $number = array_pop($parsedCasNumberArray);
            $sum += $multiplier * $number;
            $multiplier += 1;
        }
        
        if ($sum % 10 === $checkDigit) {
            return new ValidCasNumber($casNumber, $checkDigit);
        }
        
        return new InvalidCasNumber($casNumber);
    }
}
