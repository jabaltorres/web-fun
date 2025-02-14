<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Validation\Rules;

class LengthRule implements RuleInterface
{
    private ?int $min;
    private ?int $max;
    private string $message;
    
    public function __construct(?int $min = null, ?int $max = null, ?string $message = null)
    {
        $this->min = $min;
        $this->max = $max;
        $this->message = $message ?? $this->buildMessage();
    }
    
    public function validate($value): bool
    {
        $length = strlen($value);
        
        if ($this->min !== null && $length < $this->min) {
            return false;
        }
        
        if ($this->max !== null && $length > $this->max) {
            return false;
        }
        
        return true;
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
    
    private function buildMessage(): string
    {
        if ($this->min !== null && $this->max !== null) {
            return "Must be between {$this->min} and {$this->max} characters";
        }
        if ($this->min !== null) {
            return "Must be at least {$this->min} characters";
        }
        if ($this->max !== null) {
            return "Must not exceed {$this->max} characters";
        }
        return "Invalid length";
    }
} 