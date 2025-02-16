<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Validation\Rules;

class PresenceRule implements RuleInterface
{
    private string $message;
    
    public function __construct(string $message = 'Field cannot be blank')
    {
        $this->message = $message;
    }
    
    public function validate($value): bool
    {
        return !(!isset($value) || trim($value) === '');
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
} 