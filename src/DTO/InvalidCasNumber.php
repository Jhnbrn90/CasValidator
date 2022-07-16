<?php

namespace Jhnbrn90\CasValidator\DTO;

class InvalidCasNumber implements ValidatedCasNumberInterface
{
    public function __construct(public string $casNumber)
    {
        //    
    }
    
    public function isValid(): bool
    {
        return false;
    }
}