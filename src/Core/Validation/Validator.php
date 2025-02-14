<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Validation;

use Fivetwofive\KrateCMS\Core\Validation\Rules\RuleInterface;

class Validator
{
    private array $rules = [];
    private array $errors = [];
    
    public function addRule(string $field, RuleInterface $rule): self
    {
        $this->rules[$field][] = $rule;
        return $this;
    }
    
    public function validate(array $data): bool
    {
        $this->errors = [];
        
        foreach ($this->rules as $field => $rules) {
            foreach ($rules as $rule) {
                if (!isset($data[$field]) || !$rule->validate($data[$field])) {
                    $this->errors[$field][] = $rule->getMessage();
                }
            }
        }
        
        return empty($this->errors);
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
} 