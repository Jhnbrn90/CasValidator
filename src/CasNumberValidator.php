<?php

namespace Jhnbrn90\CasValidator;

use Jhnbrn90\CasValidator\DTO\InvalidCasNumber;
use Jhnbrn90\CasValidator\DTO\ValidatedCasNumberInterface;
use Jhnbrn90\CasValidator\DTO\ValidCasNumber;

class CasNumberValidator
{
    public static function validate(string $casNumber): ValidatedCasNumberInterface 
    {
        if (!preg_match('/^[1-9][0-9]{1,6}-[0-9]{2}-[0-9]$/', $casNumber)) {
            return new InvalidCasNumber($casNumber);
        }
        
        $parsedCasNumber = preg_replace("/-/", "", $casNumber);
        $parsedCasNumberArray = array_map('intval', str_split($parsedCasNumber));
        
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
