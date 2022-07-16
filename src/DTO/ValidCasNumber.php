<?php

namespace Jhnbrn90\CasValidator\DTO;

class ValidCasNumber implements ValidatedCasNumberInterface
{
    public function __construct(
        public string $casNumber, 
        public int $check_digit
    ) { 
        //
    }
    
    public function isValid(): bool
    {
        return true;
    }
}