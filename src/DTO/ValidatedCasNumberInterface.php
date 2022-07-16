<?php

namespace Jhnbrn90\CasValidator\DTO;

interface ValidatedCasNumberInterface
{
    public function isValid(): bool;
}