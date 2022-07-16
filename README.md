## CAS number validator
This PHP package allows easy parsing and [validation of CAS numbers](https://chejunkie.com/knowledge-base/validate-cas-registry-numbers) as dictated by the ACS.

### Usage
To use this package, first require it:
```bash
composer require jhnbrn90/cas-validator
```

Validating a CAS number is performed as follows:
```php
use Jhnbrn90\CasValidator\CasNumberValidator;

$validatedCas = CasNumberValidator::validate('100-39-0');

// This will yield a `ValidCasNumber` or `InvalidCasNumber` DTO

$isValid = $validatedCas->isValid(); // boolean
```