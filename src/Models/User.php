<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Models;

/**
 * User Model
 * 
 * Represents a user entity in the system
 */
class User
{
    public int $id;
    public string $username;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $role;

    /**
     * Create a new User instance
     * 
     * @param array<string, mixed> $data User data from database
     */
    public function __construct(array $data)
    {
        $this->id = (int)$data['user_id'];
        $this->username = $data['username'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->email = $data['email'];
        $this->role = $data['role'];
    }

    /**
     * Get user's full name
     */
    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    /**
     * Convert database row to User model
     * 
     * @param array<string, mixed> $row Database row
     * @return self
     */
    public static function fromDatabaseRow(array $row): self
    {
        return new self($row);
    }
} 