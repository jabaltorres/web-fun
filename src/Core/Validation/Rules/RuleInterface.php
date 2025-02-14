<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Validation\Rules;

interface RuleInterface
{
    public function validate($value): bool;
    public function getMessage(): string;
} 