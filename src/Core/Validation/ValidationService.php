<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Validation;

class ValidationService
{
    public function isBlank(?string $value): bool
    {
        return !isset($value) || trim($value) === '';
    }

    public function hasPresence(?string $value): bool
    {
        return !$this->isBlank($value);
    }

    public function hasLength(string $value, array $options): bool
    {
        if(isset($options['min']) && strlen($value) <= $options['min']) {
            return false;
        } 
        if(isset($options['max']) && strlen($value) >= $options['max']) {
            return false;
        } 
        if(isset($options['exact']) && strlen($value) !== $options['exact']) {
            return false;
        }
        return true;
    }

    public function hasInclusion($value, array $set): bool
    {
        return in_array($value, $set, true);
    }

    public function hasExclusion($value, array $set): bool
    {
        return !in_array($value, $set, true);
    }

    public function hasValidEmailFormat(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
} 