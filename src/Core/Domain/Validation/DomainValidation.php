<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation {
    public static function notNull(string $value, string $message = null)
    {
        if (empty($value)) {
            throw new EntityValidationException($message ?? 'Should not be empty');
        }
    }
    
    public static function maximumLength(string $value, int $length = 255, string $message = null)
    {
        if (strlen($value) >= $length) {
            throw new EntityValidationException($message ?? "The value must not be greater than {$length} characters");
        }
    }
    
    public static function minimumLength(string $value, int $length = 3, string $message = null)
    {
        if (strlen($value) < $length) {
            throw new EntityValidationException($message ?? "The value must not be at least {$length} characters");
        }
    }
    
    public static function nullWithMaximumLength(string $value, int $length = 255, string $message = null)
    {
        if (!empty($value) && strlen($value) >= $length) {
            throw new EntityValidationException($message ?? "The value must not be greater than {$length} characters");
        }
    }
}